<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                {!! Form::label('email', __('messages.email') , ['class' => 'form-label']) !!}
                <span class="text-danger">(*)</span>
                {!! Form::email('email', old('email', $customer->email ?? ''), ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('fullname', __('messages.fullname') , ['class' => 'form-label']) !!}<span
                    class="text-danger">(*)</span>
                {!! Form::text('fullname', old('fullname', $customer->fullname ?? ''), ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('customer_catalogue_id', __('messages.customer.table.sourceSelect'), ['class' =>
                'form-label']) !!}
                <span class="text-danger">(*)</span>
                {!! Form::select('customer_catalogue_id', [ __('messages.customer.table.sourceSelect')] +
                $sources->pluck('name', 'id')->toArray(),
                old('customer_catalogue_id', $customer->source_id ?? ''), ['class' => 'form-select
                init-select2']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('customer_catalogue_id', __('messages.customer.table.customerGroup'), ['class' =>
                'form-label']) !!}
                <span class="text-danger">(*)</span>
                {!! Form::select('customer_catalogue_id', ['' => __('messages.customer.table.customerGroupSelect')] +
                $customerCatalogues->pluck('name', 'id')->toArray(),
                old('customer_catalogue_id', $customer->customer_catalogue_id ?? ''), ['class' => 'form-select
                init-select2']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('birthday', __('messages.birthday'), ['class' => 'form-label']) !!}
                {!! Form::input('date', 'birthday', old('birthday', $customer->birthday ?? ''), ['class' =>
                'form-control'])
                !!}
            </div>

            @if (request()->routeIs('customer.create'))
            <div class="col-md-6">
                {!! Form::label('password', __('messages.password'), ['class'
                => 'form-label']) !!} <span class="text-danger">(*)</span>

                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('re_password', __('messages.rePassword'),
                ['class' => 'form-label']) !!}<span class="text-danger">(*)</span>
                {!! Form::password('re_password', ['class' => 'form-control']) !!}
            </div>
            @endif
            <div class="col-md-6">
                {!! Form::label('image', __('messages.image'), ['class' => 'form-label']) !!}
                {!! Form::text('image', old('image', $customer->image ?? ''), ['readonly', 'data-type' => 'Images',
                'class'
                => 'form-control upload-image']) !!}
            </div>



        </div>
    </div>
</div>