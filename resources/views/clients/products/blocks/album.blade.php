@if (isset($albums) && count($albums) > 0)
<div class="row">
    <div class="col-lg-10 order-lg-2">
        <div class="single-product-thumbnail-wrap zoom-gallery">
            <div class="single-product-thumbnail product-large-thumbnail-3 axil-product">
                @foreach ($albums as $album)
                <div class="thumbnail">
                    <a href="{{$album}}" class="popup-zoom">
                        <img src="{{$album}}" alt="{{$product->name}}">
                    </a>
                </div>
                @endforeach
            </div>
            <div class="discount-wrap">
                {!! $price['discountHtml'] !!}
            </div>
        </div>
    </div>
    <div class="col-lg-2 order-lg-1">
        <div class="product-small-thumb-3 small-thumb-wrapper">
            @foreach ($albums as $album)
            <div class="small-thumb-img">
                <img src="{{$album}}" alt="{{$product->name}}">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif