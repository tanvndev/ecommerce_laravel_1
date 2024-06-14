<div class="col-lg-3">
    <div class="axil-shop-sidebar">
        <div class="d-lg-none">
            <button class="sidebar-close filter-close-btn"><i class="fas fa-times"></i></button>
        </div>
        <div class="toggle-list product-categories active">
            <h6 class="title">Danh mục sản phẩm</h6>
            <div class="shop-submenu">
                @for ($i = 0; $i < 3; $i++) <div class="mb-3 ps-0 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            @endfor
        </div>
    </div>
    <div class="toggle-list product-categories product-gender active">
        <h6 class="title">Tình trạng sản phẩm</h6>
        <div class="shop-submenu">
            <div class="mb-3 ps-0 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <div class="mb-3 ps-0 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
        </div>
    </div>
    <div class="toggle-list product-color active">
        <h6 class="title">Đánh giá</h6>
        <div class="shop-submenu">
            <div class="mb-3 ps-0 form-check filter-star">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                </label>
            </div>
            <div class="mb-3 ps-0 form-check filter-star">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star"></i>
                </label>
            </div>
            <div class="mb-3 ps-0 form-check filter-star">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star "></i>
                    <i class="flaticon-star"></i>
                </label>
            </div>
            <div class="mb-3 ps-0 form-check filter-star">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star "></i>
                    <i class="flaticon-star "></i>
                    <i class="flaticon-star"></i>
                </label>
            </div>
            <div class="mb-3 ps-0 form-check filter-star">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">
                    <i class="flaticon-star active"></i>
                    <i class="flaticon-star"></i>
                    <i class="flaticon-star"></i>
                    <i class="flaticon-star"></i>
                    <i class="flaticon-star"></i>
                </label>
            </div>

        </div>
    </div>
    @empty(!$filters)
    @foreach ($filters as $filter)
    <div class="toggle-list product-size active">
        <h6 class="title">{{$filter->languages->first()->pivot->name}}</h6>
        <div class="shop-submenu">
            @foreach ($filter->attributes as $attribute)
            <div class="mb-3 ps-0 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" value="{{$attribute->id}}"
                    for="exampleCheck1">{{$attribute->languages->first()->pivot->name}}</label>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    @endempty

    <div class="toggle-list product-price-range active">
        <h6 class="title">PRICE</h6>
        <div class="shop-submenu">
            <ul>
                <li class="chosen"><a href="#">30</a></li>
                <li><a href="#">5000</a></li>
            </ul>
            <form action="#" class="mt--25">
                <div id="slider-range"></div>
                <div class="flex-center mt--20">
                    <span class="input-range">Price: </span>
                    <input type="text" id="amount" class="amount-range" readonly>
                </div>
            </form>
        </div>
    </div>
    <button class="axil-btn btn-bg-primary">Đặt lại tất cả</button>
</div>
</div>