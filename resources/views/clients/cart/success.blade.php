@extends('layouts.clientLayout')

@section('content')

<div class="container">
    <div class="order-complete">
        <div class="order-complete__message">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="40" fill="#3EB75E"></circle>
                <path
                    d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                    fill="white"></path>
            </svg>
            <h3>Đơn hàng của bạn đã hoàn tất!</h3>
            <p>Cảm ơn bạn. Đơn đặt hàng của bạn đã được nhận.</p>
        </div>
        <div class="order-info">
            <div class="order-info__item">
                <label>Mã đơn hàng</label>
                <span>{{$order['code']}}</span>
            </div>
            <div class="order-info__item">
                <label>Ngày đặt hàng</label>
                <span>{{convertDateTime($order['created_at'] ?? 0, 'H:i - d/m/Y')}}</span>
            </div>
            <div class="order-info__item">
                <label>Tổng</label>
                <span>{{ formatCurrency($order['cart']['total'] ?? 0) }}</span>
            </div>
            <div class="order-info__item">
                <label>Phương thức thanh toán</label>
                <span>{{ array_column(__('payment.method'), 'title', 'name')[$order['payment_method']] }}</span>

            </div>
        </div>
        <div class="checkout__totals-wrapper">
            <div class="checkout__totals">
                <h3>Chi tiết đơn hàng</h3>
                <table class="checkout-cart-items mb-2">
                    <thead>
                        <tr>
                            <th width="40%">Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá niêm yết</th>
                            <th>Giá bán</th>
                            <th>Thành tiền</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order['cart']['detail'] as $item)
                        @php
                        $name = $item->name;
                        $canonical = ($item->code == '') ? write_url($item->canonical) : write_url($item->canonical) .
                        '?attribute_id=' . $item->code;
                        $originalPrice = $item->originalPrice;
                        $price = $item->price;
                        $qty = $item->qty;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="img-thumbnail img-product" src="{{ $item->image }}" alt="{{ $name }}">
                                    <a href="{{$canonical}}" title="{{$name}}">
                                        {{ $name }}
                                        {{-- <span class="quantity fw-bold text-primary ms-1">x{{ $qty }}</span> --}}
                                    </a>
                                </div>
                            </td>
                            <td>
                                <span class="quantity fw-bold text-primary ms-1">x{{ $qty }}</span>
                            </td>
                            <td>
                                <div class="price">
                                    {{formatCurrency($originalPrice)}}
                                </div>
                            </td>
                            <td>
                                <div class="price">
                                    {{formatCurrency($price)}}
                                </div>
                            </td>
                            <td>
                                <div class="price">
                                    {{formatCurrency($price * $qty)}}

                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <table class="checkout-totals-2">
                    @php
                    $discount = $order['promotion']['discount'] ?? 0;
                    @endphp
                    <tbody>
                        <tr>
                            <th>TẠM TÍNH</th>
                            <td>{{ formatCurrency($order['cart']['total'] ) }}</td>
                        </tr>
                        <tr>
                            <th>PHÍ VẬN CHUYỂN</th>
                            <td>Miễn phí</td>
                        </tr>
                        <tr>
                            <th>GIẢM GIÁ</th>
                            <td>- {{formatCurrency($discount)}}</td>
                        </tr>
                        <tr>
                            <th>TỔNG</th>
                            <td>{{formatCurrency($order['cart']['total'] - $discount)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="checkout__totals-wrapper">
            <div class="checkout__totals">
                <h3>Thông tin nhận hàng</h3>
                <div class="info-address">
                    <p>Họ và tên: <span>{{$order['fullname'] ?? ''}}</span></p>
                    <p>Email: <span>{{$order['email'] ?? ''}}</span></p>
                    <p>Số điện thoại: <span>{{$order['phone'] ?? ''}}</span></p>
                    <p>Địa chỉ: <span>{{$order['address'] ?? ''}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
@endsection