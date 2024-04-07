@extends('layouts.serverLayout')

@section('script')
<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js
')}}"></script>
@endsection

@section('content')
@php
$url = $config['method'] == 'create' ? route('language.store') : route('language.update', $language->id);
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

                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                            {{__('messages.noteNotice')[1]}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                {!! Form::label('name', __('messages.language.table.name'), ['class' => 'form-label'])
                                !!}<span class="text-danger">(*)</span>
                                {!! Form::text('name', old('name', $language->name ?? ''), ['class' => 'form-control'])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('canonical', __('messages.canonical'), ['class' => 'form-label'])
                                !!}<span class="text-danger">(*)</span>
                                {!! Form::text('canonical', old('canonical', $language->canonical ?? ''), ['class' =>
                                'form-control']) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Form::label('image', __('messages.image'), ['class' => 'form-label']) !!}
                                <input readonly type="text" name="image" data-type="Images"
                                    value="{{old('image', $language->image ?? '')}}" class="form-control upload-image">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- Row end  -->

    </div>
</div>

{!! Form::close() !!}
@endsection