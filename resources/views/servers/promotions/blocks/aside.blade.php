<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.timeApplication')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3 ">
                    {!! Form::label('start_date', __('messages.startDate'), ['class' => 'form-label']) !!} <span
                        class="text-danger">(*)</span>
                    {!! Form::datetimeLocal('start_date', old('start_date', $promotion->start_date ??
                    date('Y-m-d\TH:i')), ['class' => 'form-control']) !!}
                </div>
                <div class="mb-3 ">
                    {!! Form::label('end_date', __('messages.endDate'), ['class' => 'form-label']) !!} <span
                        class="text-danger">(*)</span>

                    @php
                    $disabled = old('neverEndDate', $slide->neverEndDate ?? '') != '' ? 'disabled' : '';
                    $value = $disabled ? '' : old('end_date', $promotion->end_date ?? date('Y-m-d\TH:i'));
                    @endphp

                    {!! Form::datetimeLocal('end_date', $value, ['class' => 'form-control', $disabled, 'id' =>
                    'end_date']) !!}

                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-12 ">
                    <div class="d-flex align-items-center ">
                        {!! Form::label('', __('messages.noStoppingDay') , ['class' => 'form-label mb-0']) !!}
                        <div class="checkbox-wrapper-35 ms-4 ">
                            {{ Form::checkbox('neverEndDate', 'active', old('neverEndDate', $slide->neverEndDate ?? ''),
                            ['id' => 'switch-neverEndDate-setting', 'class' => 'switch']) }}
                            <label for="switch-neverEndDate-setting">
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
                        {{ Form::radio('sourceStatus', 'all', old('sourceStatus', $promotion->sourceStatus ?? 'all'),
                        ['class'
                        =>'form-check-input', 'id' => "all-source"]) }}
                        {{ Form::label("all-source", 'Áp dụng cho toàn bộ nguồn khách', ['class' => 'form-check-label'])
                        }}
                    </div>

                    <div class="form-check fs-15 mb-4">
                        {{ Form::radio('sourceStatus', 'choose', old('sourceStatus', $promotion->sourceStatus ?? ''),
                        ['class'
                        =>'form-check-input', 'id' => "choose-source"]) }}
                        {{ Form::label("choose-source", 'Chọn nguồn khách áp dụng', ['class' => 'form-check-label'])
                        }}
                    </div>

                    @php
                    $sourceStatus = old('sourceStatus', $promotion->sourceStatus ?? '');
                    $selected = in_array(old('sourceValue', $promotion->sourceValue ?? ''),
                    $sources->pluck('id')->toArray());
                    @endphp

                    @empty(!$sourceStatus)
                    <div class="source-wrapper">
                        {!! Form::select('sourceValue[]', $sources->pluck('name', 'id')->toArray(), $selected , ['class'
                        => 'form-select mutiple-select2', 'multiple']) !!}
                    </div>
                    @endempty


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
                        {{ Form::radio('applyStatus', 'all', old('applyStatus', $promotion->applyStatus ?? 'all'),
                        ['class' =>'form-check-input', 'id' => "all-apply"]) }}
                        {{ Form::label("all-apply", 'Áp dụng cho toàn bộ nguồn khách', ['class' => 'form-check-label'])
                        }}
                    </div>

                    <div class="form-check fs-15 mb-4">
                        {{ Form::radio('applyStatus', 'choose', old('applyStatus', $promotion->applyStatus ?? ''),
                        ['class' =>'form-check-input', 'id' => "choose-apply"]) }}
                        {{ Form::label("choose-apply", 'Chọn nguồn khách áp dụng', ['class' => 'form-check-label'])
                        }}
                    </div>

                    @php
                    $applyStatus = old('applyStatus', $promotion->applyStatus ?? '');
                    $applyValue = old('applyValue', $promotion->applyValue ?? '');

                    $selected = in_array($applyValue,
                    collect(__('general.apply_condition_item_select'))->pluck('id')->toArray());
                    @endphp

                    @empty(!$applyStatus)
                    <div class="apply-condition-wrapper">
                        <div class="mb-3">
                            {!! Form::select('applyValue[]',
                            collect(__('general.apply_condition_item_select'))->pluck('name',
                            'id')->toArray(), $selected, ['class' => 'form-select mutiple-select2 apply-condition-item',
                            'multiple']) !!}
                        </div>
                    </div>
                    @endempty
                    <input type="hidden" class="apply_condition_item_set" value="{{json_encode($applyValue)}}">
                    @empty(!$applyValue)
                    @foreach ($applyValue as $key => $value)
                    <input type="hidden" class="child_condition_item_{{$value}}" value="{{ json_encode(old($value)) }}">
                    @endforeach
                    @endempty
                </div>
            </div>
        </div>
    </div>
</div>