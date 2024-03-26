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
<form action="{{route('language.handleTranslate', $modelObject->id)}}" method="post" enctype="multipart/form-data">

    @csrf
    @method('PUT')
    <div class="body d-flex py-3">

        <input type="hidden" name="option[languageId]" value="{{$option['languageId']}}">
        <input type="hidden" name="option[model]" value="{{$option['model']}}">

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
                    {{-- Main --}}
                    @include('servers.includes.content', ['model'=> $modelObject, 'disabled' => true])

                    {{-- Seo --}}
                    @include('servers.includes.seo', ['model'=> $modelObject, 'disabled' => true])
                </div>


                {{-- Translate --}}
                <div class="col-lg-6">
                    {{-- Main --}}
                    @include('servers.includes.contentTranslate', ['model'=> $modelObjectTranslate])

                    {{-- Seo --}}
                    @include('servers.includes.seoTranslate', ['model'=> $modelObjectTranslate])
                </div>



            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection