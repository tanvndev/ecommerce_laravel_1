@extends('layouts.serverLayout')

@section('style')
<link href="{{asset('assets/servers/plugin/nice-select/nice-select.css')}}" rel="stylesheet" />

@endsection
@section('script')
<script src="{{ asset('assets/servers/plugin/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/servers/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script>
@endsection

@section('content')
{!! Form::open(['route' => 'system.store', 'method' => 'post']) !!}
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
        </div>
        <div class="row g-3">
            <div class="col-lg-12 col-md-12">
                <div class="tab-filter d-flex align-items-center justify-content-between mb-3 flex-wrap">
                    <ul class="nav nav-tabs tab-card tab-body-header rounded  d-inline-flex w-sm-100">
                        @foreach ($systemConfig as $key => $system)
                        <li class="nav-item"><a class="nav-link {{$key == 'homePage' ? 'active' : ''}}"
                                data-bs-toggle="tab" href="#tab-{{$key}}">{{$system['name']}}</a></li>
                        @endforeach

                    </ul>
                </div>
                <div class="tab-content mt-1">
                    @foreach ($systemConfig as $key => $system)
                    <div class="tab-pane fade {{$key == 'homePage' ? 'show active' : ''}}" id="tab-{{$key}}">
                        <div class="card mb-3 card-create">
                            <div class="card-header py-3 bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                                <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                                    {{__('messages.noteNotice')[1]}}</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 align-items-center">
                                    @foreach ($system['value'] as $keyVal => $value)
                                    @php
                                    $baseName = strtolower($key.'_'.$keyVal);
                                    $name = "config[{$baseName}]";
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            {!! Form::label($name, $value['label'], ['class' => 'form-label']) !!}

                                            @isset($value['title'])
                                            <span class="text-danger ms-1 ">({{$value['title']}})</span>

                                            @endisset

                                            @isset($value['link']['href'])
                                            <a class="link-info ms-1" href="{{$value['link']['href']}}"
                                                target="_blank">({{$value['link']['text']}})</a>
                                            @endisset
                                        </div>

                                        @switch($value['type'])
                                        @case('text')
                                        {!! Form::text($name, old($name, $systems[$baseName] ?? ''), ['class' =>
                                        'form-control', 'id' => $name])
                                        !!}
                                        @break

                                        @case('image')
                                        <div class="col-md-3">
                                            <img class="img-thumbnail h-250 w-100 img-contain cursor-pointer img-target"
                                                src="{{ (old($name, $systems[$baseName] ?? asset('assets/servers/images/others/upload-photo.png'))) ?? asset('assets/servers/images/others/upload-photo.png') }}"
                                                alt="upload-photo">
                                            {!! Form::hidden($name, old($name, $systems[$baseName] ?? '') )!!}
                                        </div>
                                        @break

                                        @case('email')
                                        {!! Form::email($name, old($name, $systems[$baseName] ?? ''), ['class' =>
                                        'form-control', 'id' => $name])
                                        !!}
                                        @break

                                        @case('select')
                                        {!! Form::select($name, $value['options'], old($name, $systems[$baseName] ??
                                        ''),
                                        ['class' =>
                                        'init-nice-select w-100', 'id' => $name]) !!}
                                        @break

                                        @case('textarea')
                                        {!! Form::textarea($name, old($name, $systems[$baseName] ?? ''), ['class' =>
                                        'form-control
                                        textarea-expand',
                                        'id' => $name,
                                        'rows' => 4
                                        ]) !!}
                                        @break

                                        @case('editor')
                                        {!! Form::textarea($name, old($name, $systems[$baseName] ?? ''), ['class' =>
                                        'form-control textarea-expand init-ckeditor',
                                        'id' => $name,
                                        'rows' => 4
                                        ]) !!}
                                        @break

                                        @endswitch
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}

@overwrite