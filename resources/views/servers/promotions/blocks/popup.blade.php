<!-- Modal -->
<div class="modal fade modal-custom-create " id="find-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        {!! Form::open(['method' => 'post', 'class' => 'create-menu-catalogue']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  fw-bold">Chọn sản phẩm có sẵn hoặc tìm kiếm.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="deadline-form">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <div class="search-product-wrap mt-0 ">
                                <input type="text" class="form-control input-product-search"
                                    placeholder="Tìm kiếm ở đây...">
                                <i class="icofont-search icon-search"></i>

                                <div class="search-product-result card">
                                    @for ($i = 0; $i < 7; $i++) <div class="row product-item">
                                        <div class="col-md-8">
                                            <div class="product-item-info">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="" />
                                                </div>
                                                <div class="product-info">
                                                    <div class="product-img">
                                                        <img class="img-thumbnail"
                                                            src="https://cdn.movertix.com/media/catalog/product/cache/image/1200x/i/p/iphone-12-red-128gb.jpg"
                                                            alt="">
                                                    </div>

                                                    <div class="product-title">
                                                        <div class="d-flex ">
                                                            <p class="name">iPhone 12 128GB sản xuất mới nhất năm
                                                                2024</p>
                                                            <p class="variant">(Phiên bản:
                                                                <span>
                                                                    Xanh, vàng, đỏ
                                                                </span>)
                                                            </p>
                                                        </div>
                                                        <p>Mã SP: <span>1999019209</span></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-price-stock">
                                                <p class="price">12.000.000đ</p>
                                                <div class="stock">
                                                    <p>
                                                        Tồn kho: <span>2.000</span>
                                                    </p>
                                                    <p>
                                                        Có thể bán: <span>20.000</span>
                                                    </p>

                                                </div>
                                            </div>

                                        </div>
                                </div>

                                @endfor
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary px-4 py-2 "
                data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
            <button type="submit" class="btn btn-success text-white px-4 py-2 ">{{__('messages.saveButton')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>