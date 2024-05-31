<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('province_id', __('messages.cities'), ['class' => 'form-label']) !!}
            {!! Form::select('province_id',
            ['' => __('messages.cities')] + $provinces->pluck('name', 'code')->toArray(), old('province_id',
            $user->province_id ?? ''), ['class' => ' locations init-select2 provinces' . ($errors->has('address') ? '
            is-invalid' : ''), 'data-target' => 'districts'])
            !!}

            <div class="invalid-feedback">
                {{ $errors->first('province_id') }}
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('district_id', __('messages.districts'), ['class' => 'form-label']) !!}
            {!! Form::select('district_id', ['' => __('messages.districts')], null, ['class' => 'locations init-select2
            districts' . ($errors->has('address') ? ' is-invalid' : ''), 'data-target' => 'wards']) !!}

            <div class="invalid-feedback">
                {{ $errors->first('district_id') }}
            </div>
        </div>


    </div>

    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('ward_id', __('messages.wards'), ['class' => 'form-label']) !!}
            {!! Form::select('ward_id', ['' => __('messages.wards')], null, ['class' => 'wards init-select2' .
            ($errors->has('address') ? ' is-invalid' : '')]) !!}

            <div class="invalid-feedback">
                {{ $errors->first('ward_id') }}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('address', __('messages.address')) !!}
    {!! Form::text('address', old('address'), ['placeholder' => 'Nhập vào địa chỉ chi tiết', 'class' => 'form-control' .
    ($errors->has('address') ? ' is-invalid' : '')])
    !!}

    <div class="invalid-feedback">
        {{ $errors->first('address') }}
    </div>
</div>