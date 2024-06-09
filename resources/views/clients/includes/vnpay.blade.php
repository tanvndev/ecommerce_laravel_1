@empty (!$paymentReturn)
<p>Nội dung thanh toán: <span>{{$paymentReturn['vnp_OrderInfo'] ?? ''}}</span></p>
<p>Mã GD Tại VNPAY: <span>{{$paymentReturn['vnp_TransactionNo'] ?? ''}}</span></p>
<p>Mã Ngân hàng: <span>{{$paymentReturn['vnp_BankCode'] ?? ''}}</span></p>
@endempty