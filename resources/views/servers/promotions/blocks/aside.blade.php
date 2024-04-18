<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.timeApplication')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3 ">
                    {!! Form::label('start_date', __('messages.startDate'), ['class' => 'form-label']) !!}
                    {!! Form::datetimeLocal('start_date', old('start_date', $promotion->start_date ??
                    date('Y-m-d\TH:i')), ['class' => 'form-control']) !!}
                </div>
                <div class="mb-3 ">
                    {!! Form::label('end_date', __('messages.endDate'), ['class' => 'form-label']) !!}
                    {!! Form::datetimeLocal('end_date', old('end_date', $promotion->end_date ?? date('Y-m-d\TH:i')),
                    ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-12 ">
                    <div class="d-flex align-items-center ">
                        {!! Form::label('', __('messages.noStoppingDay') , ['class' => 'form-label mb-0']) !!}
                        <div class="checkbox-wrapper-35 ms-4 ">
                            {{ Form::checkbox('setting[neverEnd]', 'active',
                            old('setting.neverEnd', $slide->setting['neverEnd'] ?? ''), ['id' =>
                            'switch-neverEnd-setting', 'class' => 'switch']) }}
                            <label for="switch-neverEnd-setting">
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
            </div>
        </div>

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.applicableCustomer')}}</h6>
            </div>
            <div class="card-body">
                <div class="col-md-12 ">

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

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.applicableObject')}}</h6>
            </div>
            <div class="card-body">
                <div class="col-md-12 ">
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