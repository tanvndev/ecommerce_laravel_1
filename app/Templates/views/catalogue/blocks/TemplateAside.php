<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.parentId')}}</h6>
                <small class="text-danger ">*{{__('messages.parentIdNotice')}}</small>
            </div>

            <div class="card-body">
                {!! Form::label('parent_id', __('messages.parentId'), ['class' => 'form-label']) !!}
                {!! Form::select('parent_id', $dropdown, old('parent_id', ${moduleTemplate}->parent_id ?? ''),
                ['class' => 'form-select init-select2']) !!}
            </div>
        </div>
        <div class="card mb-3 card-create">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    {!! Form::label('publish', __('messages.publish'), ['class' => 'form-label']) !!}
                    {!! Form::select('publish', __('general.publish'), old('publish',
                    ${moduleTemplate}->publish ?? ''), ['class' => 'form-select init-select2']) !!}
                </div>

                <div>
                    {!! Form::label('follow', __('messages.follow'), ['class' => 'form-label']) !!}
                    {!! Form::select('follow', __('general.follow'), old('follow', ${moduleTemplate}->follow
                    ?? ''), ['class' => 'form-select init-select2']) !!}
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.image')}}</h6>
            </div>
            <div class="card-body">
                <img class="img-thumbnail h-250 w-100 img-contain img-target" src="{{ (old('image', ${moduleTemplate}->image ?? asset('assets/servers/images/others/upload-photo.png'))) ?? asset('assets/servers/images/others/upload-photo.png') }}" alt="upload-photo">
                <input type="hidden" name="image" value="{{old('image', ${moduleTemplate}->image ?? '')}}" class="image">
            </div>
        </div>

    </div>
</div>