{!! Form::open(['route' => 'order.index', 'method' => 'get', 'class' => 'form-list-filter']) !!}
<div class="row">
    @include('servers.includes.filterPerpage')
    <div class="col-lg-7">
        <div class="row gy-3">

            <div class="col-lg-4">
                {!! Form::select('confirm', __('cart.confirm'),
                request('confirm'), ['class' => 'form-select filter']) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::select('payment', __('cart.payment'),
                request('payment'), ['class' => 'form-select filter']) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::select('delivery', __('cart.delivery'),
                request('delivery'), ['class' => 'form-select filter']) !!}
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <div class="input-date w-100">
                        {!! Form::text('created_at', request('created_at'), ['class' => 'form-control
                        date-range-picker', 'autocomplete' => 'off', 'readonly' => 'true'])
                        !!}
                        <div class="icon-input-date">
                            <i class="icofont-ui-calendar"></i>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    @include('servers.includes.filterSearch')
</div>
{!! Form::close() !!}