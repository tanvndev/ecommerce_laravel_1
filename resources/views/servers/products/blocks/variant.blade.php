<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Sản phẩm có nhiều phiên bản</h6>
        <small>Cho phép nhiều phiên bản khác nhau của sản phẩm. Mỗi phiên bản sẽ là một dòng trong
            mục danh sách phiên bản sản phẩm</small>
    </div>

    <div class="card-body">
        <div class="form-check">
            {!! Form::checkbox('accept', '1', old('accept') ? true : (isset($product) &&
            count($product->product_variants) > 0 ? true : false), ['class' => 'form-check-input turn-on-variant', 'id'
            => 'check-box-variant-accept']) !!}
            {!! Form::label('check-box-variant-accept', __('Sản phẩm này có nhiều biến thể. Ví dụ như màu sắc, kích
            thước,...'), ['class' => 'form-check-label']) !!}
        </div>

    </div>
    <div class="card-body variant-wrap">
        <div class="variant-body">
            @php
            $variantCatalogues = old('attributeCatalogue', isset($product) ? json_decode($product->attributeCatalogue,
            true) : []);
            @endphp

            @foreach ($variantCatalogues as $keyAttrCatalogue => $valAttrCatalogue)
            <div class="row d-flex align-items-center variant-item">
                <div class="col-md-4">
                    <label class="form-label text-info">Chọn thuộc tính</label>
                    <select class="init-nice-select w-100 choose-attribute" name="attributeCatalogue[]">
                        <option selected>Chọn thuộc tính</option>
                        @foreach ($attributeCatalogues as $attributeCatalogue)
                        <option {{ $valAttrCatalogue==$attributeCatalogue->id ? 'selected' : '' }} value="{{
                            $attributeCatalogue->id }}">
                            {{ $attributeCatalogue->attribute_catalogue_language->first()->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label text-info">Chọn giá trị tìm kiếm (nhập 2 từ để tìm kiếm)</label>
                    <div class="select-variant-wrap">
                        <select class="form-select form-control select-variant variant-{{$valAttrCatalogue}}"
                            name="attribute[{{$valAttrCatalogue}}][]" multiple
                            data-catalogue-id="{{$valAttrCatalogue}}"></select>
                    </div>
                </div>
                <div class="col-md-1 mt-25">
                    <button type="button" class="btn btn-danger py-2 delete-variant">
                        <i class="icofont-trash fs-6 text-white "></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-4 mt-4 btn-add-variant-wrap">
            <button type="button" class="btn btn-outline-info w-100 border-style-dashed add-variant">Tạo phiên bản
                mới</button>
        </div>
    </div>


</div>

<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Danh sách phiên bản</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-variant">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>