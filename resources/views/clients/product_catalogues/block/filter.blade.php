<div class="col-lg-3">
    <div class="axil-shop-sidebar">
        <div class="d-lg-none">
            <button class="sidebar-close filter-close-btn"><i class="fas fa-times"></i></button>
        </div>
        <input type="hidden" id="product_catalogue_id" name="product_catalogue_id"
            value="{{$products->first()->product_catalogue_id ?? ''}}">

        {{-- <div class="toggle-list product-categories product-gender active">
            <h6 class="title">Tình trạng sản phẩm</h6>
            <div class="shop-submenu">
                <div class="mb-3 ps-0 form-check">
                    <input type="checkbox" class="form-check-input " id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <div class="mb-3 ps-0 form-check">
                    <input type="checkbox" class="form-check-input " id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
            </div>
        </div> --}}
        @empty(!$filters)
        @foreach ($filters as $filter)
        @php
        $name = $filter->languages->first()->pivot->name;
        @endphp
        <div class="toggle-list product-size active">
            <h6 class="title">{{$name}}</h6>
            <div class="shop-submenu">
                @foreach ($filter->attributes as $attribute)
                @php
                $name = $attribute->languages->first()->pivot->name;
                $forAndId = 'attribute_' . $attribute->attribute_catalogue_id . ',' . $attribute->id;
                @endphp
                <div class="mb-3 ps-0 form-check">
                    <input type="checkbox" name="attribute[]" value="{{$attribute->id}}"
                        class="form-check-input filtering" id="{{$forAndId}}"
                        data-catalogue="{{$attribute->attribute_catalogue_id}}">
                    <label class="form-check-label" for="{{$forAndId}}">{{$name}}</label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endempty

        <div class="toggle-list product-color active">
            <h6 class="title">Đánh giá</h6>
            <div class="shop-submenu">
                {!!renderRatingFilter()!!}
            </div>
        </div>

        <div class="toggle-list product-price-range active">
            <h6 class="title mb-5">Lọc theo giá</h6>
            <div class="shop-submenu">
                <div id="slider-range"></div>
                <div class="flex-center gap-4 mt--30">
                    <input type="text" id="amount-start" name="price" class="amount-range filtering" readonly>
                    <input type="text" id="amount-end" name="price" class="amount-range filtering" readonly>
                </div>
            </div>
        </div>
        <button onclick="window.location.reload()" type="button" class="axil-btn btn-bg-primary">Đặt lại tất cả</button>
    </div>

</div>
