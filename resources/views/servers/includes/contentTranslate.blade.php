<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                {!! Form::label('translate_name', __('messages.name'), ['class' => 'form-label']) !!} <span
                    class="text-danger">(*)</span>
                {!! Form::text('translate_name', old('translate_name', $model->name ?? ''), ['class' => 'form-control'])
                !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('translate_description', __('messages.description'), ['class' => 'form-label']) !!}
                {!! Form::textarea('translate_description', old('translate_description', $model->description ?? ''),
                ['id' => 'ckDescription_2', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' => 5]) !!}
            </div>

            <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    {!! Form::label('translate_content', __('messages.content'), ['class' => 'form-label']) !!}
                    <a href="" class="form-label link-primary mutipleUploadImageCkEditor"
                        data-target="ckContent_2">{{__('messages.uploadMultipleImage')}}</a>
                </div>
                {!! Form::textarea('translate_content', old('translate_content', $model->content ?? ''), ['id' =>
                'ckContent_2', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' => 5, 'data-height' =>
                '500']) !!}
            </div>
        </div>

    </div>
</div>