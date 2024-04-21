{!! Form::open(['route' => 'customer.index', 'method' => 'get', 'class' => 'form-list-filter']) !!}
<div class="row">
    @include('servers.includes.filterPerpage')
    <div class="col-lg-7">
        <div class="row">
            @include('servers.includes.filterPublish')

            <div class="col-lg-4">
                {!! Form::select('customer_catalogue_id', ['' => __('messages.customer.table.customerGroupSelect')] +
                $customerCatalogues->pluck('name', 'id')->toArray(),
                request('customer_catalogue_id'), ['class' => 'form-select filter']) !!}
            </div>
        </div>
    </div>
    @include('servers.includes.filterSearch')
</div>
{!! Form::close() !!}