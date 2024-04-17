<div class="col-lg-3">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.basic')}}</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center slide-banner-inner">
                    <div class="col-md-12">
                        {!! Form::label('name', __('messages.slideName') , ['class' => 'form-label']) !!}
                        <span class="text-danger">(*)</span>
                        {!! Form::text('name', old('name', $slide->name ?? ''), ['class' => 'form-control'])
                        !!}
                    </div>

                    <div class="col-md-12">
                        {!! Form::label('keyword', __('messages.keyword') , ['class' => 'form-label'])
                        !!} <span class="text-danger">(*)</span>
                        {!! Form::text('keyword', old('keyword', $slide->keyword ?? ''), ['class' =>
                        'form-control convert-to-slug']) !!}
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[width]', __('messages.width') , ['class' => 'form-label
                            form-label-custom']) !!}
                            <div class="input-group ">
                                {!! Form::text('setting[width]', old('setting.width', $slide->setting['width'] ?? '') ??
                                '0',
                                ['class' => 'form-control text-end int ']) !!}
                                <span class="input-group-text">px</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[height]', __('messages.height') , ['class' => 'form-label
                            form-label-custom ']) !!}
                            <div class="input-group ">
                                {!! Form::text('setting[height]', old('setting.height', $slide->setting['height'] ?? '')
                                ?? '0', ['class' =>
                                'form-control text-end int']) !!}
                                <span class="input-group-text">px</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[animation]', __('messages.effect') , ['class' => 'form-label
                            form-label-custom ']) !!}
                            {!! Form::select('setting[animation]', __('general.effect'), old('setting.animation',
                            $slide->setting['animation'] ?? ''),
                            ['class' => 'init-nice-select w-100'])
                            !!}

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[arrow]', __('messages.arrow') , ['class' => 'form-label mb-0']) !!}
                            <div class="checkbox-wrapper-35 ms-4 ">
                                {{ Form::checkbox('setting[arrow]', 'active',
                                old('setting.arrow', $slide->setting['arrow'] ?? '') ?? true, ['id' =>
                                'switch-arrow-setting', 'class' => 'switch']) }}
                                <label for="switch-arrow-setting">
                                    <span class="switch-x-text">{{__('messages.status')}}
                                    </span>
                                    <span class="switch-x-toggletext">
                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked:
                                            </span>{{__('messages.off')}}</span>
                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked:
                                            </span>Bật</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('', __('messages.follow') , ['class' => 'form-label mb-0']) !!}
                            <div class="ms-4">
                                @foreach (__('general.navigate') as $navigate => $title)
                                @php
                                $settingNavigate = old('setting.navigate', ($slide->setting['navigate'] ?? null));
                                $checked = ($settingNavigate == $navigate || ($settingNavigate == null && $navigate
                                == 'dots'));
                                @endphp
                                <div class="form-check">
                                    {{ Form::radio('setting[navigate]', $navigate, $checked, ['class' =>
                                    'form-check-input', 'id' => "$navigate-$title"]) }}
                                    {{ Form::label("$navigate-$title", $title, ['class' => 'form-check-label']) }}
                                </div>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center slide-banner-inner">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('', __('messages.runAuto') , ['class' => 'form-label mb-0']) !!}
                            <div class="checkbox-wrapper-35 ms-4 ">
                                {{ Form::checkbox('setting[autoplay]', 'active',
                                old('setting.autoplay', $slide->setting['autoplay'] ?? ''), ['id' =>
                                'switch-autoplay-setting', 'class' => 'switch']) }}
                                <label for="switch-autoplay-setting">
                                    <span class="switch-x-text">{{__('messages.status')}}
                                    </span>
                                    <span class="switch-x-toggletext">
                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked:
                                            </span>{{__('messages.off')}}</span>
                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked:
                                            </span>Bật</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('', __('messages.stopOnHover') , ['class' => 'form-label mb-0']) !!}
                            <div class="checkbox-wrapper-35 ms-4 ">
                                {{ Form::checkbox('setting[pauseHover]', 'active',
                                old('setting.pauseHover', $slide->setting['pauseHover'] ?? ''), ['id' =>
                                'switch-pauseHover-setting', 'class' => 'switch']) }}
                                <label for="switch-pauseHover-setting">
                                    <span class="switch-x-text">{{__('messages.status')}}</span>
                                    <span class="switch-x-toggletext">
                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked:
                                            </span>{{__('messages.off')}}</span>
                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked:
                                            </span>{{__('messages.on')}}</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 ">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[animationDelay]', __('messages.changeScene') , ['class' =>
                            'form-label
                            form-label-custom']) !!}
                            <div class="input-group ">
                                {!! Form::text('setting[animationDelay]',
                                old('setting.animationDelay', $slide->setting['animationDelay'] ?? ''), ['class' =>
                                'form-control text-end int']) !!}
                                <span class="input-group-text">ms</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="d-flex align-items-center ">
                            {!! Form::label('setting[animationSpeed]', __('messages.effectSpeed') , ['class' =>
                            'form-label form-label-custom ']) !!}
                            <div class="input-group ">
                                {!! Form::text('setting[animationSpeed]', old('setting.animationSpeed',
                                $slide->setting['animationSpeed'] ?? ''), ['class' => 'form-control text-end int']) !!}
                                <span class="input-group-text">ms</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Shortcode</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center slide-banner-inner">
                    <div class="mb-3">
                        {{ Form::label('short_code', 'Shortcode', ['class' => 'form-label']) }}
                        {{ Form::textarea('short_code', old('short_code', $slide->short_code ?? ''), ['class' =>
                        'form-control textarea-expand',
                        'id' => 'short_code',
                        'rows' => 3]) }}
                    </div>

                </div>


            </div>


        </div>

    </div>
</div>