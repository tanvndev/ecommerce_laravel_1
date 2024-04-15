<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.parentId')}}</h6>
                <small class="text-danger ">*{{__('messages.parentIdNotice')}}</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    {!! Form::label('product_catalogue_id', __('messages.parentId'), ['class' => 'form-label']) !!}
                    {!! Form::select('product_catalogue_id', $dropdown, old('product_catalogue_id',
                    $product->product_catalogue_id ?? ''), ['class' => 'form-select init-select2']) !!}
                </div>

                @php
                if (!empty($product->product_catalogues)) {
                $catalogues = $product->product_catalogues->pluck('id')->toArray();
                // Tạo một bản sao của mảng $dropdown và loại bỏ phần tử có key là product_catalogue_id
                $filteredDropdown = array_diff_key($dropdown, [$product->product_catalogue_id]);
                }

                // dd($catalogues);
                @endphp

                <div>
                    {!! Form::label('catalogue', __('messages.catalogueSub'), ['class' => 'form-label']) !!}
                    {!! Form::select('catalogue[]', $filteredDropdown ?? $dropdown, old('catalogue', $catalogues ?? []),
                    ['class' =>
                    'form-select init-select2', 'multiple']) !!}
                </div>


            </div>


        </div>

        <div class="card mb-3 card-create">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.generalInfomation')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    {!! Form::label('sku', 'Mã sản phẩm', ['class' => 'form-label']) !!}
                    {!! Form::text('sku', old('sku', $product->sku ?? time()), ['class' => 'form-control']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('origin', 'Xuất sứ', ['class' => 'form-label']) !!}
                    {!! Form::text('origin', old('origin', $product->origin ?? ''), ['class' => 'form-control']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('price', 'Giá bán sản phẩm', ['class' => 'form-label']) !!}
                    {!! Form::text('price', formatToCommas(old('price', $product->price ?? '')), ['class' =>
                    'form-control int']) !!}
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.image')}}</h6>
            </div>
            <div class="card-body">
                <img class="img-thumbnail h-250 w-100 img-contain img-target"
                    src="{{ (old('image', $product->image ?? asset('assets/servers/images/others/upload-photo.png'))) ?? asset('assets/servers/images/others/upload-photo.png') }}"
                    alt="upload-photo">
                {!! Form::hidden('image', old('image', $product->image ?? ''), ['class' => 'image']) !!}
            </div>
        </div>

        <div class="card mb-3 card-create">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    {!! Form::label('publish', __('messages.publish'), ['class' => 'form-label']) !!}

                    {!! Form::select('publish', __('general.publish'), old('publish', $product->publish ?? ''),
                    ['class' => 'form-select init-select2']) !!}
                </div>

                <div>
                    {!! Form::label('follow', __('messages.follow'), ['class' => 'form-label']) !!}

                    {!! Form::select('follow', __('general.follow'), old('follow', $product->follow ?? ''),
                    ['class' => 'form-select init-select2']) !!}
                </div>
            </div>
        </div>

    </div>
</div>