@if(isset($widgets['home-outstanding-products']) && count($widgets['home-outstanding-products']->object) > 0)
<div class="axil-product-area bg-color-white axil-section-gap">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="title-highlighter highlighter-primary"> <i class="far fa-shopping-basket"></i> Sản phẩm của
                chúng tôi</span>
            <h2 class="title">Sản phẩm nổi bật</h2>
        </div>
        <div
            class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
            <div class="slick-single-layout">
                <div class="row row--15">
                    @foreach ($widgets['home-outstanding-products']->object as $outstandingProduct)
                    @php
                    $name = $outstandingProduct->languages->first()->pivot->name;
                    $canonical = write_url($outstandingProduct->languages->first()->pivot->canonical);
                    $image = $outstandingProduct->image;
                    $price = getPrice($outstandingProduct);
                    $review = getReview($outstandingProduct);
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                        <div class="axil-product product-style-one">
                            <div class="thumbnail">
                                <a href="{{ $canonical }}" title="{{$name}}">
                                    <img data-sal="zoom-out" data-sal-delay="200" data-sal-duration="800" loading="lazy"
                                        class="main-img" src="{{ $image }}" alt="Product Images">
                                </a>
                                {!! $price['discountHtml'] !!}
                                <div class="product-hover-action">
                                    <ul class="cart-action">
                                        <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a>
                                        </li>
                                        {!! renderQuickView($outstandingProduct, $canonical, $name) !!}
                                        <li class="wishlist"><a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="inner">
                                    <div class="product-rating">
                                        <span class="icon">
                                            {!! $review['star'] !!}
                                        </span>
                                        <span class="rating-number">({{$review['count']}})</span>
                                    </div>
                                    <h5 class="title"><a href="{{ $canonical }}" title="{{ $name}}">{{ $name }}</a></h5>
                                    <div class="product-price-variant">
                                        {!! $price['priceHtml'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- End Single Product  -->
                </div>
            </div>
            <!-- End .slick-single-layout -->

        </div>
        <div class="row">
            <div class="col-lg-12 text-center mt--20 mt_sm--0">
                <a href="shop.html" class="axil-btn btn-bg-lighter btn-load-more">Xem tất cả</a>
            </div>
        </div>

    </div>
</div>
@endif