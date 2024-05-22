@if (isset($widgets['home-arrival-product']) && count($widgets['home-arrival-product']->object) > 0)
<div class="axil-new-arrivals-product-area bg-color-white axil-section-gap pb--0">
    <div class="container">
        <div class="product-area pb--50">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-primary"><i class="far fa-shopping-basket"></i>Sản phẩm
                    mới</span>
                <h2 class="title">Sản phẩm mới ra mắt</h2>
            </div>
            <div class="new-arrivals-product-activation slick-layout-wrapper--30 axil-slick-arrow  arrow-top-slide">
                @foreach ($widgets['home-arrival-product']->object as $arrivalProduct)
                @if (count($arrivalProduct->products) > 0)
                @foreach ($arrivalProduct->products as $productArr)

                @php
                $name = $productArr->languages->first()->pivot->name;
                $canonical = write_url($productArr->languages->first()->pivot->canonical);
                $image = $productArr->image;
                $price = formatCurrency($productArr->price);
                // $review = getReview($productArr);
                $price = getPrice($productArr);
                @endphp
                <div class="slick-single-layout">
                    <div class="axil-product product-style-two">
                        <div class="thumbnail">
                            <a href="{{$canonical}}" title="{{$name}}">
                                <img data-sal="zoom-out" data-sal-delay="200" data-sal-duration="500" src="{{$image}}"
                                    alt="Product Images">
                            </a>
                            {!! $price['discountHtml'] !!}
                        </div>
                        <div class="product-content">
                            <div class="inner">
                                <div class="color-variant-wrapper">
                                    <ul class="color-variant">
                                        <li class="color-extra-01 active"><span><span class="color"></span></span>
                                        </li>
                                        <li class="color-extra-02"><span><span class="color"></span></span>
                                        </li>
                                        <li class="color-extra-03"><span><span class="color"></span></span>
                                        </li>
                                    </ul>
                                </div>
                                <h5 class="title"><a href="{{$canonical}}" title="{{$name}}">{{$name}}</a></h5>
                                <div class="product-price-variant">
                                    {!! $price['priceHtml'] !!}
                                </div>
                                <div class="product-hover-action">
                                    <ul class="cart-action">
                                        <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></li>
                                        <li class="select-option"><a href="single-product.html">Thêm vào giỏ hàng</a>
                                        </li>
                                        <li class="wishlist"><a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .slick-single-layout -->
                @endforeach
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@endif