<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.contactInfo')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                {!! Form::label('province_id', __('messages.cities'), ['class' => 'form-label']) !!}
                {!! Form::select('province_id',
                ['' => __('messages.cities')] + $provinces->pluck('name', 'code')->toArray(), old('province_id',
                $customer->province_id ?? ''),
                ['class' => 'form-select init-select2 locations provinces', 'data-target' => 'districts']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('district_id', __('messages.districts'), ['class' => 'form-label']) !!}
                {!! Form::select('district_id', ['' => __('messages.districts')], null, ['class' => 'form-select
                init-select2 locations districts', 'data-target' => 'wards']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('ward_id', __('messages.wards'), ['class' => 'form-label']) !!}
                {!! Form::select('ward_id', ['' => __('messages.wards')], null, ['class' => 'form-select init-select2
                wards']) !!}
            </div>


            <div class="col-md-6">
                {!! Form::label('phone', __('messages.phone'), ['class' => 'form-label']) !!}
                {!! Form::text('phone', old('phone', $customer->phone ?? ''), ['class' => 'form-control', 'type' =>
                'tel'])
                !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('address', __('messages.address'), ['class' => 'form-label']) !!}
                {!! Form::text('address', old('address', $customer->address ?? ''), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('description', __('messages.notes'), ['class' => 'form-label']) !!}
                {!! Form::text('description', old('description', $customer->description ?? ''), ['class' =>
                'form-control'])
                !!}
            </div>


        </div>
    </div>
</div>