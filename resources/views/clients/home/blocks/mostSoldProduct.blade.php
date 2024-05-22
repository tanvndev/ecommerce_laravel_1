@if(isset($widgets['home-most-sold']) && count($widgets['home-most-sold']->object) > 0)
<div class="axil-most-sold-product axil-section-gap">
    <div class="container">
        <div class="product-area pb--50">
            <div class="section-title-wrapper section-title-center">
                <span class="title-highlighter highlighter-primary"><i class="fas fa-star"></i> Sản phẩm bán chạy</span>
                <h2 class="title">Sản phẩm bán chạy nhất cửa hàng</h2>
            </div>
            <div class="row row-cols-xl-2 row-cols-1 row--15">
                @foreach ($widgets['home-most-sold']->object as $mostSoldProduct)
                @php
                $name = $mostSoldProduct->languages->first()->pivot->name;
                $canonical = write_url($mostSoldProduct->languages->first()->pivot->canonical);
                $image = $mostSoldProduct->image;
                $price = getPrice($mostSoldProduct);
                $review = getReview($mostSoldProduct);
                @endphp

                <div class="col">
                    <div class="axil-product-list">
                        <div class="thumbnail">
                            <a href="single-product.html">
                                <img data-sal="zoom-in" data-sal-delay="100" data-sal-duration="1500" src="{{ $image }}"
                                    alt="{{ $name }}">
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="rating-icon">
                                    {!! $review['star'] !!}
                                </span>
                                <span class="rating-number"><span>{{ $review['count'] }}</span> Reviews</span>
                            </div>
                            <h6 class="product-title"><a href="{{ $canonical }}}" title="{{ $name }}">{{ $name }}</a>
                            </h6>
                            <div class="product-price-variant">
                                {!! $price['priceHtml'] !!}
                            </div>
                            <div class="product-cart">
                                <a href="cart.html" class="cart-btn"><i class="fal fa-shopping-cart"></i></a>
                                <a href="wishlist.html" class="cart-btn"><i class="fal fa-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif