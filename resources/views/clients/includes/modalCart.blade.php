<div class="cart-dropdown" id="cart-dropdown">
    <div class="cart-content-wrap">
        <div class="cart-header">
            <h2 class="header-title">Giỏ hàng</h2>
            <button class="cart-close sidebar-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-body">
            <ul class="cart-item-list">
                {{-- @if (!count($carts) > 0)
                @foreach ($carts as $cart)
                @php
                $canonical = ($cart->code == '') ? write_url($cart->canonical) : write_url($cart->canonical) .
                '?attribute_id=' . $cart->code;
                @endphp
                <li class="cart-item" data-rowid="{{ $cart->rowId }}">
                    <div class="item-img">
                        <a href="{{ $canonical }}" title="{{ $cart->name }}">
                            <img src="{{$cart->image}}" alt="{{ $cart->name }}">
                        </a>
                        <button type="button" class="close-btn delete-cart-item"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="item-content">
                        <h3 class="item-title">
                            <a href="{{ $canonical }}" title="{{ $cart->name }}">{{ $cart->name }}</a>
                        </h3>
                        <div class="item-price">
                            <span class="price">{{formatCurrency($cart->price)}}</span>

                            @if ($cart->price != $cart->originalPrice)
                            <del>{{formatCurrency($cart->originalPrice)}}</del>
                            @endif
                        </div>
                        <div class="pro-qty item-quantity">
                            <input type="text" class="quantity-input only-number" value="{{$cart->qty}}">
                        </div>
                    </div>
                </li>
                @endforeach
                @endif --}}
                <li class="text-center">
                    <img src="/public/userfiles/image/other/icon-empty-cart.png" alt="not-cart">
                    <p>Chưa có sản phẩm nào.</p>
                </li>
            </ul>
        </div>
        <div class="cart-footer">
            <h3 class="cart-subtotal">
                <span class="subtotal-title">Tổng:</span>
                <span class="subtotal-amount">{{formatCurrency(0)}}</span>
            </h3>
            <div class="group-btn d-block">
                {{-- <a href="cart.html" class="axil-btn btn-bg-primary viewcart-btn">View Cart</a> --}}
                <a href="/checkout" class="axil-btn btn-bg-secondary checkout-btn w-100">Thanh toán</a>
            </div>
        </div>
    </div>
</div>