<div class="modal fade modal-custom-edit" id="edit-order" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['route' => ['order.update', $order->id], 'method' => 'put']) !!}
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa
                    {{lcfirst(__('messages.order.detail.info'))}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" value="{{$order->id}}" name="id">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            {!! Form::label('fullname', 'Họ và tên', ['class' => 'col-form-label']) !!}
                            {!! Form::text('fullname', old('fullname', $order->fullname), ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            {!! Form::label('phone', 'Số điện thoại', ['class' => 'col-form-label']) !!}
                            {!! Form::tel('phone', old('phone', $order->phone), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            {!! Form::label('email', 'Email', ['class' => 'col-form-label']) !!}
                            {!! Form::email('email', old('email', $order->email), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('province_id', __('messages.cities'), ['class' => 'col-form-label']) !!}
                        {!! Form::select('province_id',
                        ['' => __('messages.cities')] + $provinces->pluck('name', 'code')->toArray(), old('province_id',
                        $order->province_id ?? ''),
                        ['class' => 'form-select init-select2 locations provinces', 'data-target' => 'districts']) !!}
                    </div>

                    <div class="col-md-4">
                        {!! Form::label('district_id', __('messages.districts'), ['class' => 'col-form-label']) !!}
                        {!! Form::select('district_id', ['' => __('messages.districts')], null, ['class' => 'form-select
                        init-select2 locations districts', 'data-target' => 'wards']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('ward_id', __('messages.wards'), ['class' => 'col-form-label']) !!}
                        {!! Form::select('ward_id', ['' => __('messages.wards')], null, ['class' => 'form-select
                        init-select2
                        wards']) !!}
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3 mt-3">
                            {!! Form::label('address', __('messages.address'), ['class' => 'col-form-label']) !!}
                            {!! Form::text('address', old('address', $order->address ?? ''), ['class' =>
                            'form-control'])
                            !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('description', 'Ghi chú', ['class' => 'col-form-label']) !!}
                            {!! Form::textarea('description', old('description', $order->description), ['class' =>
                            'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2"
                    data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
                <button type="submit"
                    class="btn btn-success text-white px-4 py-2">{{__('messages.saveButton')}}</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>