@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/seo.js')}}"></script>

@endsection

@section('content')
@php
$url = $config['method'] == 'create' ? route('promotion.store') : route('promotion.update', $promotion->id);
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

            @include('servers.includes.messageError')
            {{-- Aside --}}
            @include('servers.promotions.blocks.aside')

            <div class="col-lg-8">
                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                            {{__('messages.noteNotice')[1]}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                {!! Form::label('name', __('messages.promotion.table.name'), ['class' => 'form-label'])
                                !!} <span class="text-danger">(*)</span>
                                {!! Form::text('name', old('name', $promotion->name ?? ''), ['class' => 'form-control'])
                                !!}
                            </div>

                            <div class="col-md-6">
                                {!! Form::label('code', __('messages.promotion.table.code'), ['class' => 'form-label'])
                                !!}
                                {!! Form::text('code', old('code', $promotion->code ?? ''), ['class' => 'form-control'])
                                !!}
                            </div>

                            <div class="col-md-12">
                                {!! Form::label('description', __('messages.description'), ['class' => 'form-label'])
                                !!}
                                {!! Form::textarea('description', old('description', $promotion->description ?? ''),
                                ['class' => 'form-control textarea-expand', 'rows' => 3, 'cols' => 30]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.infoDetail')}}</h6>
                        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                            {{__('messages.noteNotice')[1]}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                {!! Form::label('', __('messages.promotion.table.promotionType'), ['class' =>
                                'form-label mb-3'])!!}

                                <select class="form-select init-select2 " name="" id="">
                                    <option selected>Select one</option>
                                    <option value="">New Delhi</option>
                                    <option value="">Istanbul</option>
                                    <option value="">Jakarta</option>
                                </select>

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