{!! Form::open(['route' => 'user.catalogue.index', 'method' => 'get', 'class' => 'form-list-filter']) !!}
<div class="row">
    @include('servers.includes.filterPerpage')
    <div class="col-lg-7">
        <div class="row">
            @include('servers.includes.filterPublish')
        </div>
    </div>
    @include('servers.includes.filterSearch')
</div>
{!! Form::close() !!}