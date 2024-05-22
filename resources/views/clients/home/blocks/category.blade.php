@if(isset($widgets['categories']) && count($widgets['categories']->object) > 0)
<div class="axil-categorie-area bg-color-white axil-section-gapcommon">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="title-highlighter highlighter-secondary"> <i class="far fa-tags"></i> Danh mục</span>
            <h2 class="title">Tìm kiếm bằng danh mục</h2>
        </div>
        <div class="categrie-product-activation slick-layout-wrapper--15 axil-slick-arrow  arrow-top-slide">
            @foreach ($widgets['categories']->object as $category)
            @php
            $name = $category->languages->first()->pivot->name;
            $canonical = write_url($category->languages->first()->pivot->canonical);
            $image = $category->image;
            @endphp
            <div class="slick-single-layout">
                <div class="categrie-product" data-sal="zoom-out" data-sal-delay="200" data-sal-duration="500">
                    <a href="{{ $canonical }}}" title="{{$name}}">
                        <img class="img-fluid" src="{{$image}}" alt="{{$name}}">
                        <h6 class="cat-title">{{$name}}</h6>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif