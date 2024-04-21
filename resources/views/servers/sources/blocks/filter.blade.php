{!! Form::open(['route' => 'source.index', 'method' => 'get', 'class' => 'form-list-filter']) !!}
<div class="row">
    @include('servers.includes.filterPerpage')

    <div class="col-lg-7">
        <div class="row">
            @include('servers.includes.filterPublish')

            {!! Form::select('source_catalogue_id', $dropdown, null, [
            'class' => 'form-select filter',
            'placeholder' => __('messages.source.table.sourceCatalogue')
            ]) !!}
        </div>
    </div>
    @include('servers.includes.filterSearch')
</div>
{!! Form::close() !!}