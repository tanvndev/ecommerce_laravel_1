<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.parentId')}}</h6>
                <small class="text-danger ">*{{__('messages.parentIdNotice')}}</small>
            </div>
            <div class="card-body">
                <div class="mb-3 ">
                    <label class="form-label">{{__('messages.parentId')}}</label>
                    {!! Form::select('{moduleTemplate}_catalogue_id', $dropdown, null, [
                    'class' => 'form-select init-select2',
                    'placeholder' => __('messages.parentId')
                    ]) !!}
                </div>

                @php
                if (!empty(${moduleTemplate}->{moduleTemplate}_catalogues)) {
                $catalogues = ${moduleTemplate}->{moduleTemplate}_catalogues->pluck('id')->toArray();
                // Tạo một bản sao của mảng $dropdown và loại bỏ phần tử có key là {moduleTemplate}_catalogue_id
                $filteredDropdown = array_diff_key($dropdown, [${moduleTemplate}->{moduleTemplate}_catalogue_id]);
                }
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
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{__('messages.publish')}}</label>
                    {!! Form::select('publish', __('messages.general.publish'), old('publish', ${moduleTemplate}->publish ??
                    ''), [
                    'class' => 'form-select init-select2',
                    ]) !!}
                </div>

                <div>
                    <label class="form-label">{{__('messages.follow')}}</label>
                    {!! Form::select('follow', __('messages.general.follow'), old('follow', ${moduleTemplate}->follow ?? ''), [
                    'class' => 'form-select init-select2',
                    ]) !!}
                </div>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.image')}}</h6>
            </div>
            <div class="card-body">
                <img class="img-thumbnail h-250 w-100 img-contain img-target" src="{{ (old('image', ${moduleTemplate}->image ?? asset('assets/servers/images/others/upload-photo.png'))) ?? asset('assets/servers/images/others/upload-photo.png') }}" alt="upload-photo">
                {!! Form::hidden('image', old('image', ${moduleTemplate}->image ?? ''), ['class' => 'image']) !!}
            </div>

        </div>
    </div>