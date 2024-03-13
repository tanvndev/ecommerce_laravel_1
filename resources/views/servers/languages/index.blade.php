@extends('layouts.serverLayout')

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['table']}}</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a href="{{route('language.create')}}" class="btn btn-primary btn-set-task w-sm-100">
                            <i class="icofont-plus-circle me-2 fs-6"></i>{{$config['seo']['create']}} </a>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row clearfix g-3">
            <div class="col-sm-12">

                <div class="card mb-2">
                    <div class="card-body ">
                        {{-- Toolbox --}}
                        @include('servers.includes.toolbox', ['model' =>'Language'] )
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body ">
                        {{-- Filter --}}
                        @include('servers.languages.blocks.filter')
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        @include('servers.languages.blocks.table')
                        {{-- Pagination --}}
                        <div class="mt-3 pagination-list-text">
                            {{ $languages->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Row End -->

    </div>
</div>
@endsection