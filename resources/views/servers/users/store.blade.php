@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script>

<script>
    // Lấy ra id của địa điểm để gán vào js
    var district_id = "{{isset($user->district_id) ? $user->district_id : old('district_id')}}";
    var ward_id = "{{isset($user->ward_id) ? $user->ward_id : old('ward_id') }}";
</script>

<script src="{{asset('assets/servers/js/library/location.js')}}"></script>

@endsection


@section('content')
@php
$url = $config['method'] == 'create' ? route('user.store') : route('user.update', $user->id);
$method = $config['method'] == 'create' ? 'POST' : 'PUT';
@endphp

{!! Form::open(['method' => $method, 'url' => $url, 'files' => true]) !!}

<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                    <button type="submit"
                        class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">{{__('messages.saveButton')}}
                </div>
            </div>
        </div> <!-- Row end  -->



        <div class="row g-3 mb-3 justify-content-center ">

            <div class="col-lg-10">

                @include('servers.includes.messageError')

                {{-- Thông tin chung --}}
                @include('servers.users.blocks.general')

                {{-- Address --}}
                @include('servers.users.blocks.address')


            </div>
        </div><!-- Row end  -->

    </div>
</div>

{!! Form::close() !!}



@endsection