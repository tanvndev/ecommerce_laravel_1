@extends('layouts.clientLayout')

@section('style')
<link href="{{asset('assets/servers/plugin/nice-select/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('script')
<script src="{{ asset('assets/clients/js/library/productCatalogue.js') }}"></script>
<script src="{{ asset('assets/servers/plugin/nice-select/jquery.nice-select.min.js') }}"></script>

<script>
    if ($(".init-nice-select").length > 0) {
        $(".init-nice-select").niceSelect();
    }
</script>
@endsection

@section('content')
{{-- Start Breadcrumb --}}
@include('clients.includes.breadcrumb', ['model' => $productCatalogue, 'breadcrumb' => $breadcrumb])
{{-- End Breadcrumb --}}
<!-- Start Shop Area  -->
<div class="axil-shop-area axil-section-gap bg-color-white">
    <div class="container">
        <div class="row">
            @include('clients.product_catalogues.block.filter')
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="axil-shop-top mb--40">
                            <div
                                class="category-select align-items-center justify-content-lg-end justify-content-between">
                                <!-- Start Single Select  -->
                                <div class="me-3">
                                    <select class="init-nice-select" id="sort">
                                        <option value="">Short by Latest</option>
                                        <option value="">Short by Oldest</option>
                                        <option value="">Short by Name</option>
                                        <option value="">Short by Price</option>
                                    </select>
                                </div>
                                <div class="me-3">
                                    <select class="init-nice-select" id="perpage">
                                        <option value="">Short by Latest</option>
                                        <option value="">Short by Oldest</option>
                                        <option value="">Short by Name</option>
                                        <option value="">Short by Price</option>
                                    </select>
                                </div>
                                <!-- End Single Select  -->
                            </div>
                            <div class="d-lg-none">
                                <button class="product-filter-mobile filter-toggle"><i class="fas fa-filter"></i>
                                    FILTER</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
                <div class="row row--15 product-filter-list">
                    @if (!is_null($products) && count($products) > 0)
                    @foreach ($products as $product)
                    @php
                    $name = $product->languages->first()->pivot->name;
                    $canonical = write_url($product->languages->first()->pivot->canonical);
                    $image = $product->image;
                    $price = getPrice($product);
                    $review = getReview(5);
                    @endphp
                    <div class="col-xl-4 col-sm-6">
                        <div class="axil-product product-style-one mb--30">
                            <div class="thumbnail">
                                <a href="{{ $canonical }}" title="{{ $name }}">
                                    <img src="{{ asset($image) }}" alt="{{ $name }}">
                                </a>
                                {!! $price['discountHtml'] !!}
                                <div class="product-hover-action">
                                    <ul class="cart-action">
                                        <li class="wishlist"><a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </li>
                                        {!! renderQuickView($product, $canonical, $name) !!}
                                        <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="inner">
                                    <h5 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
                                    </h5>
                                    <div class="product-price-variant">
                                        {!! $price['priceHtml'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product  -->

                    @endforeach
                    @else
                    <div class="text-center">
                        <img src="/public/userfiles/image/other/icon-empty-cart.png" alt="not-cart">
                        <p>Chưa có sản phẩm nào.</p>
                    </div>
                    @endif
                </div>
                <div class="text-center pt--20 product-pagination">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    <!-- End .container -->
</div>
<!-- End Shop Area  -->

<!-- Start Axil Newsletter Area  -->
@include('clients.includes.newsletter')
<!-- End Axil Newsletter Area  -->
@endsection