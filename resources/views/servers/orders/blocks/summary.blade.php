<div class="col-xl-12 col-xxl-8">
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
            <h6 class="mb-0 fw-bold ">Tóm tắt đơn hàng</h6>
            <span
                class="ms-3 badge bg-{{__('order.payment')[$order->payment]['color']}}">{{__('cart.payment')[$order->payment]}}</span>
        </div>
        <div class="card-body">
            @php
            $total = formatCurrency($order->cart['total'] - $order->promotion['discount']);
            @endphp
            <div class="product-cart">
                <div class="checkout-table">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table display table-hover align-middle nowrap no-footer dtr-inline"
                                style="width: 100%;" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th width="40%">
                                            Sản phẩm
                                        </th>
                                        <th>
                                            Số lượng
                                        </th>
                                        <th>
                                            Giá bán
                                        </th>
                                        <th>
                                            Giá khuyến mãi
                                        </th>
                                        <th>
                                            Thành tiến
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->cart['detail'] as $item)
                                    @php
                                    $option = $item['options'][0];
                                    $canonical = ($option['code'] == '') ? write_url($option['canonical']) :
                                    write_url($option['canonical']) . '?attribute_id=' . $option['code'];
                                    @endphp
                                    <tr role="row" class="odd">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{$option['image']}}" class="avatar rounded lg "
                                                    alt="{{$item['name']}}">
                                                <a href="{{$canonical}}"
                                                    class="title link text-primary mb-0 ms-2">{{$item['name']}}</a>
                                            </div>
                                        </td>
                                        <td>
                                            {{$item['qty']}}
                                        </td>
                                        <td>
                                            <p class="price">{{formatCurrency($option['originalPrice'])}}
                                            </p>

                                        </td>
                                        <td>
                                            <p class="price">{{formatCurrency($item['price'])}}</p>
                                        </td>
                                        <td>
                                            <p class="price">{{formatCurrency($item['price'] *
                                                $item['qty'])}}</p>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="checkout-coupon-total checkout-coupon-total-2 d-flex flex-wrap justify-content-end">
                    <div class="checkout-total mt-4 border-left-0">
                        <div class="single-total">
                            <p class="value">Tạm tính:</p>
                            <p class="price">{{ formatCurrency($order->cart['total']) }}</p>
                        </div>
                        <div class="single-total">
                            <p class="value">Phí vận chuyển (+):</p>
                            <p class="price">Miễn phí</p>
                        </div>
                        <div class="single-total">
                            <p class="value">Mã giảm giá (-):</p>
                            <p class="price">{{formatCurrency($order->promotion['discount'])}}</p>
                        </div>

                        <div class="single-total total-payable">
                            <p class="value mt-3  fs-5">Tổng:</p>
                            <p class="price mt-3 fs-5 fw-bold ">{{$total}}</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="card-body mt-3 border-top py-4">
            @php
            $confirm = $order->confirm
            @endphp
            <div class="row">

                <div class="col-md-6">
                    <div class="d-flex align-items-center gx-3 order-status-info">
                        <div class="icon {{__('order.confirm')[$confirm]['color']}}">
                            <i class="{{__('order.confirm')[$confirm]['icon']}} fs-5"></i>
                        </div>
                        <div>
                            <p class="delivery">{{__('order.confirm')[$confirm]['title']}} </p>
                            <p class="method">{{ array_column(__('payment.method'), 'title',
                                'name')[$order->payment_method] }}</p>
                        </div>
                    </div>
                </div>
                @if ($confirm != 'cancel')
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {!! Form::open(['route' => ['order.update', $order->id], 'method' => 'put']) !!}
                        @php
                        $confirmAttributes = [
                        'pending' => ['value' => 'success', 'text' => 'Xác nhận', 'color' => 'success'],
                        'success' => ['value' => 'cancel', 'text' => 'Hủy đơn', 'color' => 'danger']
                        ];
                        $attributes = $confirmAttributes[$confirm] ?? $confirmAttributes['pending'];
                        @endphp
                        <input type="hidden" name="confirm" value="{{ $attributes['value'] }}">
                        <button type="submit"
                            class="btn btn-{{ $attributes['color'] }} text-uppercase text-white px-4 py-2">
                            {{ $attributes['text'] }}
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>