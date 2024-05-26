@extends('layouts.clientLayout')
@section('content')

@section('script')
<script src="{{ asset('assets/clients/js/library/home.js') }}"></script>
@endsection

{{-- Start Banner Area --}}
@include('clients.home.blocks.banner')
{{-- End Banner Area --}}

<!-- Start Categorie Area  -->
@include('clients.home.blocks.category')
<!-- End Categorie Area  -->

<!-- Poster Countdown Area  -->
@include('clients.home.blocks.countdown')
<!-- End Poster Countdown Area  -->

<!-- Start Outstanding Product Area  -->
@include('clients.home.blocks.outstandingProduct')
<!-- End Outstanding Product Area  -->

<!-- Start Testimonila Area  -->
@include('clients.home.blocks.testimonial')
<!-- End Testimonila Area  -->

<!-- Start New Arrivals Product Area  -->
@include('clients.home.blocks.arrivalsProduct')
<!-- End New Arrivals Product Area  -->

<!-- Start Most Sold Product Area  -->
@include('clients.home.blocks.mostSoldProduct')
<!-- End Most Sold Product Area  -->

<!-- Start Why Choose Area  -->
@include('clients.home.blocks.whyChoose')
<!-- End Why Choose Area  -->


<!-- Start Axil Product Poster Area  -->
<div class="axil-poster">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb--30">
                <div class="single-poster">
                    <a href="shop.html">
                        <img src="assets/clients/images/product/poster/poster-01.png" alt="eTrade promotion poster">
                        <div class="poster-content">
                            <div class="inner">
                                <h3 class="title">Rich sound, <br> for less.</h3>
                                <span class="sub-title">Collections <i class="fal fa-long-arrow-right"></i></span>
                            </div>
                        </div>
                        <!-- End .poster-content -->
                    </a>
                </div>
                <!-- End .single-poster -->
            </div>
            <div class="col-lg-6 mb--30">
                <div class="single-poster">
                    <a href="shop-sidebar.html">
                        <img src="assets/clients/images/product/poster/poster-02.png" alt="eTrade promotion poster">
                        <div class="poster-content content-left">
                            <div class="inner">
                                <span class="sub-title">50% Offer In Winter</span>
                                <h3 class="title">Get VR <br> Reality Glass</h3>
                            </div>
                        </div>
                        <!-- End .poster-content -->
                    </a>
                </div>
                <!-- End .single-poster -->
            </div>
        </div>
    </div>
</div>
<!-- End Axil Product Poster Area  -->

<!-- Start Axil Newsletter Area  -->
<div class="axil-newsletter-area axil-section-gap pt--0">
    <div class="container">
        <div class="etrade-newsletter-wrapper bg_image bg_image--5">
            <div class="newsletter-content">
                <span class="title-highlighter highlighter-primary2"><i
                        class="fas fa-envelope-open"></i>Newsletter</span>
                <h2 class="title mb--40 mb_sm--30">Get weekly update</h2>
                <div class="input-group newsletter-form">
                    <div class="position-relative newsletter-inner mb--15">
                        <input placeholder="example@gmail.com" type="text">
                    </div>
                    <button type="submit" class="axil-btn mb--15">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End .container -->
</div>
<!-- End Axil Newsletter Area  -->
@endsection