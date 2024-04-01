@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{asset('assets/servers/plugin/nice-select/nice-select.css')}}" rel="stylesheet" />

@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/servers/plugin/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/seo.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/variant.js')}}"></script>

<script>
    var attributeCatalogues = @json($attributeCatalogues->map(function ($item) {
        $name = $item->attribute_catalogue_language->first()->name;
        return ['id' => $item->id, 'name' => $name];
    }));
</script>

@endsection

@section('content')
@php
$url = $config['method'] == 'create' ? route('product.store') : route('product.update',
$product->id);

// dd($product);
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
                        <button type="submit"
                            class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">{{__('messages.saveButton')}}
                    </div>
                </div>
            </div> <!-- Row end  -->



            <div class="row g-3 mb-3 justify-content-center ">

                @include('servers.includes.messageError')
                {{-- Aside --}}

                <div class="col-lg-8">
                    {{-- Main --}}
                    {{-- @include('servers.includes.content', ['model'=> $product ?? []]) --}}

                    {{-- Album --}}
                    {{-- @include('servers.includes.album') --}}

                    {{-- Seo --}}
                    {{-- @include('servers.includes.seo', ['model'=> $product ?? []]) --}}


                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                            <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                                {{__('messages.noteNotice')[1]}}</small>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>

                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Sản phẩm có nhiều phiên bản</h6>
                            <small>Cho phép nhiều phiên bản khác nhau của sản phẩm. Mỗi phiên bản sẽ là một dòng trong
                                mục danh sách phiên bản sản phẩm</small>
                        </div>

                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input turn-on-variant" type="checkbox"
                                    id="check-box-variant-220" />
                                <label class="form-check-label" for="check-box-variant-220"> Sản phẩm này có nhiều biến
                                    thể. Ví dụ như màu
                                    sắc, kích thước,... </label>
                            </div>
                        </div>
                        <div class="card-body variant-wrap">
                            <div class="variant-body">
                            </div>
                            <div class="col-md-4 mt-4 btn-add-variant-wrap">
                                <button type="button"
                                    class="btn btn-outline-info w-100 border-style-dashed add-variant">Tạo phiên bản
                                    mới</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection