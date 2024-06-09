<?php

namespace App\Classes;

class Momo
{
    private static function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public static function payment($order)
    {
        $configMomo = config('apps.paymentConfig.momo');

        $endpoint = $configMomo['endpoint'];
        $partnerCode = $configMomo['partnerCode'];
        $accessKey = $configMomo['accessKey'];
        $secretKey = $configMomo['secretKey'];

        $orderAmount = $order['cart']['total'] - $order['promotion']['discount'];

        $orderInfo = $order['description'] ?? 'Thanh toan don hang ' . $order['code'] . ' qua MOMO.';
        $amount = $orderAmount . "";
        $orderId = $order['code'] . "";
        $returnUrl = $configMomo['returnUrl'];
        $notifyurl = $configMomo['notifyUrl'];
        // Lưu ý: link notifyUrl không phải là dạng localhost
        $bankCode = "SML";

        $requestId = time() . "";
        $requestType = "payWithMoMoATM";
        $extraData = "";

        // echo $serectkey;die;
        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&bankCode=" . $bankCode . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'bankCode' => $bankCode,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = self::execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        error_log(print_r($jsonResult, true));

        $returnData = [
            'code' => '00',
            'message' => $jsonResult['message'],
            'url' => $jsonResult['payUrl'],
        ];

        return $returnData;
    }
}
