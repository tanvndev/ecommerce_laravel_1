@empty (!$paymentReturn)
<p>Mã GD Tại MOMO: <span>{{$paymentReturn['transId'] ?? ''}}</span></p>
<p>Kiểu thanh toán: <span>{{$paymentReturn['orderType'] ?? ''}}</span></p>
<p>Loại thanh toán: <span>{{$paymentReturn['payType'] ?? ''}}</span></p>
<p>Loại thanh toán: <span>{{$paymentReturn['orderType'] ?? ''}}</span></p>
<p>Thời gian thanh toán: <span>{{$paymentReturn['responseTime'] ?? ''}}</span></p>
<p>Nội dung thanh toán: <span>{{$paymentReturn['orderInfo'] ?? ''}}</span></p>
@endempty