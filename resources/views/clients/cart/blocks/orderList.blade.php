<div class="axil-order-summery order-checkout-summery">
    <h5 class="title mb--20">Đơn hàng của bạn</h5>
    <div class="summery-table-wrap">
        <table class="table summery-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Tạm tính</th>
                </tr>
            </thead>
            <tbody>
                @if (count($carts) > 0)
                @foreach ($carts as $cart)
                @php
                $canonical = ($cart->code == '') ? write_url($cart->canonical) : write_url($cart->canonical) .
                '?attribute_id=' . $cart->code;
                @endphp
                <tr class="order-product">
                    <td>
                        <div class="d-flex align-items-center position-relative">
                            <img class="img-thumbnail img-product " src="{{$cart->image}}" alt="{{ $cart->name }}">
                            <a href="{{ $canonical }}" title="{{ $cart->name }}">
                                {{ $cart->name }} <span class="quantity fw-bold text-primary ms-2">x{{ $cart->qty
                                    }}</span>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="price">
                            @if ($cart->price != $cart->originalPrice)
                            <del>{{formatCurrency($cart->originalPrice)}}</del>
                            @endif
                            {{formatCurrency($cart->price)}}
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif

                <tr class="order-subtotal">
                    <td>Tạm tính</td>
                    <td>{{formatCurrency($carts->total ?? 0)}}</td>
                </tr>
                <tr class="order-discount">
                    <td>Giảm giá</td>
                    <td class="discount-value">- {{formatCurrency($cartPromotion['discount'] ?? 0)}}</td>
                </tr>
                <tr class="order-shipping">
                    @php
                    $transportDefault = __('payment.transportMethod')[0]['cost'];
                    @endphp
                    <td colspan="2">
                        <div class="shipping-amount">
                            <span class="title">Hình thức vận chuyển</span>
                            <span class="amount">{{formatCurrency($transportDefault)}}</span>
                        </div>
                        @foreach (__('payment.transportMethod') as $key => $transport)
                        <div class="input-group">
                            <input type="radio" class="transport-method" id="transport_{{$transport['name']}}"
                                name="shipping" value="{{$transport['cost']}}" {{ $key==0 ? 'checked' : '' }}>
                            <label for="transport_{{$transport['name']}}">{{$transport['title']}}</label>
                        </div>
                        @endforeach

                    </td>
                </tr>
                <tr class="order-total">
                    <td>Tổng tiền</td>
                    <td data-total="{{($carts->total - $cartPromotion['discount']) ?? 0 }}" class="order-total-amount">
                        {{formatCurrency($carts->total - $cartPromotion['discount'] - $transportDefault)}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @include('clients.cart.blocks.paymentMethod')
    <button type="submit" class="axil-btn btn-bg-primary checkout-btn">Xử lý Thanh toán</button>
</div>