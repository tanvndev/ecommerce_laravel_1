<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.seo')['info']}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>

        <div class="seo-view">
            <span class="link text-success translate-meta-url meta-url">{{ url('/') . '/' . old('translate_canonical',
                $model->canonical ??
                __('messages.seoExample')[0])}}</span>
            <h5 class="translate-meta-title meta-title">{{old('translate_meta_title', $model->meta_title ??
                __('messages.seoExample')[1])}}
            </h5>
            <p class="translate-meta-description meta-description" class="mb-0 ">{{old('translate_meta_description',
                $model->meta_description ??
                __('messages.seoExample')[2]) }}</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                {!! Form::label('translate_meta_title', __('messages.seo')['title'], ['class' => 'form-label']) !!}
                {!! Form::text('translate_meta_title', old('translate_meta_title', $model->meta_title ?? ''), ['class'
                => 'form-control']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('translate_meta_keyword', __('messages.seo')['keyword'], ['class' => 'form-label']) !!}
                {!! Form::text('translate_meta_keyword', old('translate_meta_keyword', $model->meta_keyword ?? ''),
                ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-12">
                {!! Form::label('translate_meta_description', __('messages.seo')['description'], ['class' =>
                'form-label']) !!}
                {!! Form::textarea('translate_meta_description', old('translate_meta_description',
                $model->meta_description ?? ''), ['class' => 'form-control', 'cols' => 30, 'rows' => 10]) !!}
            </div>

            <div class="col-md-12">
                {!! Form::label('translate_canonical', __('messages.seo')['canonical'], ['class' => 'form-label'])
                !!} <span class="text-danger">(*)</span>
                <div class="input-group">
                    <span class="input-group-text">{{ url('/') }}/</span>
                    {!! Form::text('translate_canonical', old('translate_canonical', $model->canonical ?? ''), ['class'
                    => 'form-control', 'autocomplete' => '']) !!}
                </div>
            </div>
        </div>

    </div>
</div>