@extends('layouts.serverLayout')

@section('content')
@php
$url = $config['method'] == 'create' ? route('user.catalogue.store') : route('user.catalogue.update',
$userCatalogue->id);
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
                                {!! Form::label('name', __('messages.userCatalogue.table.name'), ['class' =>
                                'form-label']) !!}<span class="text-danger">(*)</span>
                                {!! Form::text('name', old('name', $userCatalogue->name ?? ''), ['class' =>
                                'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('description', __('messages.description'), ['class' => 'form-label'])
                                !!}
                                {!! Form::text('description', old('description', $userCatalogue->description ?? ''),
                                ['class' => 'form-control']) !!}
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