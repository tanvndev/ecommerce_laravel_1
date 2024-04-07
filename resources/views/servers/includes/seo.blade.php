<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.seo')['info']}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>

        <div class="seo-view">
            <span class="link text-success meta-url">{{ url('/') . '/' . old('canonical', $model->canonical ??
                __('messages.seoExample')[0])}}</span>
            <h5 class="meta-title">{{old('meta_title', $model->meta_title ?? __('messages.seoExample')[1])}}
            </h5>
            <p class="meta-description" class="mb-0">{{old('meta_description', $model->meta_description ??
                __('messages.seoExample')[2]) }}</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                {!! Form::label('meta_title', __('messages.seo')['title'], ['class' => 'form-label']) !!}
                {!! Form::text('meta_title', old('meta_title', $model->meta_title ?? ''), ['class' => 'form-control',
                isset($disabled) ? 'disabled' : '']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('meta_keyword', __('messages.seo')['keyword'], ['class' => 'form-label']) !!}
                {!! Form::text('meta_keyword', old('meta_keyword', $model->meta_keyword ?? ''), ['class' =>
                'form-control', isset($disabled) ? 'disabled' : '']) !!}
            </div>

            <div class="col-md-12">
                {!! Form::label('meta_description', __('messages.seo')['description'], ['class' => 'form-label']) !!}
                {!! Form::textarea('meta_description', old('meta_description', $model->meta_description ?? ''), ['class'
                => 'form-control', isset($disabled) ? 'disabled' : '', 'cols' => 30, 'rows' => 10]) !!}
            </div>

            <div class="col-md-12">
                {!! Form::label('canonical', __('messages.seo')['canonical'] , ['class' => 'form-label']) !!} <span
                    class="text-danger">(*)</span>
                <div class="input-group">
                    <span class="input-group-text">{{ url('/') }}/</span>
                    {!! Form::text('canonical', old('canonical', $model->canonical ?? ''), ['class' => 'form-control',
                    isset($disabled) ? 'disabled' : '', 'autocomplete' => '']) !!}
                </div>
            </div>
        </div>

    </div>
</div>