<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.parentId')}}</h6>
                <small class="text-danger ">*{{__('messages.parentIdNotice')}}</small>
            </div>
            <div class="card-body">
                {!! Form::select('parent_id', $dropdown, old('parent_id', $postCatalogue->parent_id ?? ''), ['class' =>
                'form-select init-select2']) !!}
            </div>
        </div>
        <div class="card mb-3 card-create">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{__('messages.publish')}}</label>
                    {!! Form::select('publish', __('messages.general.publish'), old('publish', $postCatalogue->publish
                    ?? ''), ['class' => 'form-select init-select2']) !!}
                </div>

                <div>
                    <label class="form-label">{{__('messages.follow')}}</label>
                    {!! Form::select('follow', __('messages.general.follow'), old('follow', $postCatalogue->follow ??
                    ''), ['class' => 'form-select init-select2']) !!}
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
                    src="{{ (old('image', $postCatalogue->image ?? asset('assets/servers/images/others/no-image.png'))) ?? asset('assets/servers/images/others/no-image.png') }}"
                    alt="no-image">
                {!! Form::hidden('image', old('image', $postCatalogue->image ?? ''), ['class' => 'image']) !!}
            </div>
        </div>

    </div>
</div>