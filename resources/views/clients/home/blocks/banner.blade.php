@if (isset($slides['main-slide']) && count($slides['main-slide']->item) > 0)
<div class="axil-main-slider-area main-slider-style-1" data-setting="{{ json_encode($slides['main-slide']->setting) }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-sm-6">
                <div class="main-slider-content">
                    <div class="slider-content-activation-one">
                        @foreach ($slides['main-slide']->item as $slide)
                        <div class="single-slide slick-slide" data-sal="slide-up" data-sal-delay="400"
                            data-sal-duration="800">
                            <span class="subtitle"><i class="fas fa-fire"></i> {{ $slide['name'] }}</span>
                            <h1 class="title">{{ $slide['description'] }}</h1>
                            <div class="slide-action">
                                <div class="shop-btn">
                                    <a href="{{ write_url($slide['canonical']) }}" target="{{ $slide['window'] }}"
                                        title="{{ $slide['description'] }}" class="axil-btn btn-bg-white"><i
                                            class="fal fa-shopping-cart"></i>Mua ngay</a>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-6">
                <div class="main-slider-large-thumb">
                    <div class="slider-thumb-activation-one axil-slick-dots">
                        @foreach ($slides['main-slide']->item as $slide)
                        <div class="single-slide slick-slide" data-sal="slide-up" data-sal-delay="600"
                            data-sal-duration="1500">
                            <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1"><img src="{{ asset('assets/clients/images/others/shape-1.png') }}" alt="Shape"></li>
        <li class="shape-2"><img src="{{ asset('assets/clients/images/others/shape-2.png') }}" alt="Shape"></li>
    </ul>
</div>
@endif