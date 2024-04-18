@extends('layouts.serverLayout')

@section('script')

<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script>
@endsection

@section('content')
{!! Form::open(['method' => 'PUT' , 'url' => route('widget.saveTranslate')] )
!!}
<div class="body d-flex py-3">

    <input type="hidden" name="languageId" value="{{request('languageId')}}">
    <input type="hidden" name="widgetId" value="{{ $widget->id }}">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                    <button type="submit"
                        class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">{{__('messages.saveButton')}}</button>
                </div>
            </div>
        </div> <!-- Row end  -->




        <div class="row g-3 mb-3 justify-content-center ">

            @include('servers.includes.messageError')
            {{-- Aside --}}
            <div class="col-lg-6">
                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                            {{__('messages.noteNotice')[1]}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                {!! Form::label('description', __('messages.description'), ['class' => 'form-label'])
                                !!}
                                {!! Form::textarea('description', old('description', $widget->description ?? ''), ['id'
                                => 'ckDescription', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' => 5,
                                'disabled' => true])!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Translate --}}
            <div class="col-lg-6">
                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                            {{__('messages.noteNotice')[1]}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                {!! Form::label('translate_description', __('messages.description'), ['class' =>
                                'form-label'])
                                !!}
                                {!! Form::textarea('translate_description', old('translate_description',
                                $widget->translateDescription ?? ''), ['id'
                                => 'ckDescription2', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' =>
                                5]) !!}
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