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
$url = $config['method'] == 'create' ? route('post.catalogue.store') : route('post.catalogue.update',
$postCatalogue->id);
@endphp
<form action="{{ $url }}" method="post" enctype="multipart/form-data">

    @csrf
    @if ($config['method'] == 'update')
    @method('PUT')
    @endif
    <div class="body d-flex py-3">

        <div class="container-xxl">

            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                        <button type="submit" class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">Lưu
                            lại</button>
                    </div>
                </div>
            </div> <!-- Row end  -->



            <div class="row g-3 mb-3 justify-content-center ">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                {{-- Aside --}}
                @include('servers.post_catalogues.blocks.aside')

                <div class="col-lg-8">
                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thông tin chung</h6>
                            <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                    <label class="form-label">Tiêu đề nhóm bài viết <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{old('name', $postCatalogue->name ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả ngắn </label>
                                    <textarea name="description" id="description" data-height="200"
                                        class="form-control init-ckeditor" cols="30" rows="5">
                                        {{old('description', $postCatalogue->description ?? '')}}
                                    </textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Nội dung </label>
                                    <textarea name="content" id="content" data-height="500"
                                        class="form-control init-ckeditor" cols="30" rows="5">
                                        {{old('content', $postCatalogue->content ?? '')}}
                                    </textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    @include('servers.post_catalogues.blocks.seo')
                </div>
            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection