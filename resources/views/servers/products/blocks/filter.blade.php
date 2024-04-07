{!! Form::open(['route' => 'product.index', 'method' => 'get', 'class' => 'form-list-filter']) !!}
<div class="row">
    @include('servers.includes.filterPerpage')

    <div class="col-lg-7">
        <div class="row">
            @include('servers.includes.filterPublish')
            <div class="col-lg-4">
                {!! Form::select('product_catalogue_id', $dropdown, request('product_catalogue_id'), ['class' =>
                'form-select filter', 'placeholder' => __('messages.product.table.productCatalogue')]) !!}
            </div>
        </div>
    </div>
    @include('servers.includes.filterSearch')
</div>
{!! Form::close() !!}