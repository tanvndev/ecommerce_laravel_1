<?php
return [
    'vnpay' => [
        'vnp_Url' => "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
        'vnp_TmnCode' => "V0G8UB5J",
        'vnp_HashSecret' => "TMVAE18BE1EY99OVJNOPTIOR7O41B9HQ",
        'vnp_ReturnUrl' => write_url('return/vnpay'),
        'vnp_apiUrl' => "https://sandbox.vnpayment.vn/merchant_webapi/merchant.html",
        'apiUrl' => "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction",
    ]
];
