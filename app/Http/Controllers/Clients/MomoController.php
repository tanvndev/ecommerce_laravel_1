<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\OrderServiceInterface as OrderService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MomoController extends Controller
{

    private $orderRepository;
    public function __construct(
        OrderRepository $orderRepository
    ) {
        parent::__construct();
        $this->orderRepository = $orderRepository;
    }

    public function handleReturnUrl(Request $request)
    {
        $configMomo = config('apps.paymentConfig.momo');
        $secretKey = $configMomo['secretKey'];
        $inputData = $request->query();


        if (!empty($inputData)) {
            $partnerCode = $inputData["partnerCode"];
            $accessKey = $inputData["accessKey"];
            $orderId = $inputData["orderId"];
            $localMessage = utf8_encode($inputData["localMessage"]);
            $message = $inputData["message"];
            $transId = $inputData["transId"];
            $orderInfo = utf8_encode($inputData["orderInfo"]);
            $amount = $inputData["amount"];
            $errorCode = $inputData["errorCode"];
            $responseTime = $inputData["responseTime"];
            $requestId = $inputData["requestId"];
            $extraData = $inputData["extraData"];
            $payType = $inputData["payType"];
            $orderType = $inputData["orderType"];
            $m2signature = $inputData["signature"]; //MoMo signature


            //Checksum
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                "&payType=" . $payType . "&extraData=" . $extraData;

            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

            Log::debug('Momo Raw Hash: ' . $rawHash);
            Log::debug('Momo Secret Key: ' . $secretKey);
            Log::debug('Momo Partner Signature: ' . $partnerSignature);

            // dd($partnerSignature, $m2signature);

            // if ($m2signature == $partnerSignature) {
            if ($errorCode == '0') {

                $request->session()->put('paymentReturn',  $inputData);
                $request->session()->put('templatePayment',  'clients.includes.momo');

                $this->handleMomoIpn($inputData);
                return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
            }
            // }
        }
        // Xoa orderSuccess
        $request->session()->forget('orderSuccess');
        return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
    }

    private function handleMomoIpn($get)
    {
        // Tam thoi de private khi nao chuyen qua thanh toan live se chuyen thanh public va cau hinh kieu khac
        $configMomo = config('apps.paymentConfig.momo');
        $secretKey = $configMomo['secretKey'];
        if (!empty($get)) {
            $response = array();
            DB::beginTransaction();
            try {
                $partnerCode = $get["partnerCode"];
                $accessKey = $get["accessKey"];
                $serectkey = $secretKey;
                $orderId = $get["orderId"];
                $localMessage = $get["localMessage"];
                $message = $get["message"];
                $transId = $get["transId"];
                $orderInfo = $get["orderInfo"];
                $amount = $get["amount"];
                $errorCode = $get["errorCode"];
                $responseTime = $get["responseTime"];
                $requestId = $get["requestId"];
                $extraData = $get["extraData"];
                $payType = $get["payType"];
                $orderType = $get["orderType"];
                $extraData = $get["extraData"];
                $m2signature = $get["signature"]; //MoMo signature


                //Checksum
                $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                    "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                    "&payType=" . $payType . "&extraData=" . $extraData;

                $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

                $order = $this->orderRepository->findByWhere(['code' => ['=', $get["orderId"]]]);

                if ($m2signature == $partnerSignature) {
                    if ($errorCode == '0') {
                        $result = '<div class="alert alert-success">Capture Payment Success</div>';
                        $payload['payment'] = 'paid';
                    } else {
                        $payload['payment'] = 'unpaid';
                        DB::rollBack();
                        $result = '<div class="alert alert-danger">' . $message . '</div>';
                    }
                } else {
                    $payload['payment'] = 'unpaid';
                    DB::rollBack();

                    $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
                }
                $this->orderRepository->update($order->id, $payload);
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo $response['message'] = $e;
            }

            $debugger = array();
            $debugger['rawData'] = $rawHash;
            $debugger['momoSignature'] = $m2signature;
            $debugger['partnerSignature'] = $partnerSignature;

            if ($m2signature == $partnerSignature) {
                $response['message'] = "Received payment result success";
            } else {
                $response['message'] = "ERROR! Fail checksum";
            }
            $response['debugger'] = $debugger;
            // echo json_encode($response);
        }
    }
}
