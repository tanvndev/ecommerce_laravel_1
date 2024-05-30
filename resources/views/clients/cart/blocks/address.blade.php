<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('province_id', __('messages.cities'), ['class' => 'form-label']) !!}
            {!! Form::select('province_id',
            ['' => __('messages.cities')] + $provinces->pluck('name', 'code')->toArray(), old('province_id',
            $user->province_id ?? ''), ['class' => ' locations init-select2 provinces', 'data-target' => 'districts'])
            !!}
        </div>

    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('district_id', __('messages.districts'), ['class' => 'form-label']) !!}
            {!! Form::select('district_id', ['' => __('messages.districts')], null, ['class' => 'locations init-select2
            districts',
            'data-target' => 'wards']) !!}
        </div>

    </div>

    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('ward_id', __('messages.wards'), ['class' => 'form-label']) !!}
            {!! Form::select('ward_id', ['' => __('messages.wards')], null, ['class' => 'wards init-select2']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('address', __('messages.address')) !!}
    {!! Form::text('address', null, ['placeholder' => 'Nhập vào địa chỉ chi tiết', 'class' => 'form-control']) !!}
</div>