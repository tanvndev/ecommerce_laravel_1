@extends('layouts.serverLayout')

@section('content')
@if ($errors->any())
@php
$errorMessages = '';
foreach ($errors->all() as $error) {
$errorMessages .= $error . '<br>';
}
toast($errorMessages, 'error');
@endphp
@endif

<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['table']}}</h3>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row clearfix g-3">
            <div class="col-sm-12">

                <div class="card mb-2">
                    <div class="card-body ">
                        {{-- Toolbox --}}
                        @include('servers.includes.toolbox', ['model' =>'Comment'] )
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body ">
                        {{-- Filter --}}
                        @include('servers.comments.blocks.filter' )
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="card-body">

                        @include('servers.comments.blocks.table', ['modelName' =>'Comment'])
                        {{-- Pagination --}}
                        <div class="mt-3 pagination-list-text">
                            {{ $comments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Row End -->

    </div>
</div>
@endsection