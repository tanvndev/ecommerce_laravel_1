<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                {!! Form::label('name', __('messages.name') , ['class' =>
                'form-label']) !!}
                {!! Form::text('name', old('name', $model->name ?? ''), ['class' => 'form-control', isset($disabled) ?
                'disabled' : '']) !!}
            </div>


            <div class="col-md-12">
                {!! Form::label('description', __('messages.description'), ['class' => 'form-label']) !!}
                {!! Form::textarea('description', old('description', $model->description ?? ''), ['id' =>
                'ckDescription', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' => 5, isset($disabled) ?
                'disabled' : '']) !!}
            </div>


            <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="form-label">{{__('messages.content')}}</label>
                    <a href=""
                        class="form-label link-primary {{isset($disabled) ? 'd-none' : '' }} mutipleUploadImageCkEditor"
                        data-target="ckContent">{{__('messages.uploadMultipleImage')}}</a>
                </div>
                {!! Form::textarea('content', old('content', $model->content ?? ''), ['id' => 'ckContent', 'data-height'
                => '500', isset($disabled) ? 'disabled' : '', 'class' => 'form-control init-ckeditor', 'cols' => 30,
                'rows' => 5]) !!}
            </div>


        </div>
    </div>
</div>