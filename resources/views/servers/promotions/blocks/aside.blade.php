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
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-12 ">
                    <div class="d-flex align-items-center ">
                        {!! Form::label('', __('messages.noStoppingDay') , ['class' => 'form-label mb-0']) !!}
                        <div class="checkbox-wrapper-35 ms-4 ">
                            {{ Form::checkbox('neverEnd', 'active', old('neverEnd', $slide->neverEnd ?? ''), ['id' =>
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
                <div class="col-md-12 source-inner">
                    <div class="form-check fs-15 mb-2 ">
                        {{ Form::radio('source', 'all', true, ['class' =>'form-check-input', 'id' =>
                        "all-source"]) }}
                        {{ Form::label("all-source", 'Áp dụng cho toàn bộ nguồn khách', ['class' => 'form-check-label'])
                        }}
                    </div>

                    <div class="form-check fs-15 mb-4">
                        {{ Form::radio('source', 'choose', '', ['class' =>'form-check-input', 'id' =>
                        "choose-source"]) }}
                        {{ Form::label("choose-source", 'Chọn nguồn khách áp dụng', ['class' => 'form-check-label'])
                        }}
                    </div>

                </div>

            </div>
        </div>

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.applicableObject')}}</h6>
            </div>
            <div class="card-body">
                <div class="col-md-12 apply-condition-inner">
                    <div class="form-check fs-15 mb-2">
                        {{ Form::radio('apply', 'all', true, ['class' =>'form-check-input', 'id' => "all-apply"]) }}
                        {{ Form::label("all-apply", 'Áp dụng cho toàn bộ nguồn khách', ['class' => 'form-check-label'])
                        }}
                    </div>

                    <div class="form-check fs-15 mb-4">
                        {{ Form::radio('apply', 'choose', '', ['class' =>'form-check-input', 'id' =>
                        "choose-apply"]) }}
                        {{ Form::label("choose-apply", 'Chọn nguồn khách áp dụng', ['class' => 'form-check-label'])
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>