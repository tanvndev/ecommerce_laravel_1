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

<script>
    var attributeCatalogues = @json($attributeCatalogues->map(function ($item) {
        $name = $item->attribute_catalogue_language->first()->name;
        return ['id' => $item->id, 'name' => $name];
    }));

    var attributeForm = @json(old('attribute', isset($product->attribute) ? json_decode($product->attribute, true) : []));
 
    var variantForm = @json(old('variant', isset($product->variant) ? json_decode($product->variant, true) : []));

</script>

<script src="{{ asset('assets/servers/js/library/variant.js')}}"></script>
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
                @include('servers.products.blocks.aside')

                <div class="col-lg-8">
                    {{-- Main --}}
                    @include('servers.includes.content', ['model'=> $product ?? []])

                    {{-- Album --}}
                    @include('servers.includes.album')

                    {{-- Variant --}}
                    @include('servers.products.blocks.variant')

                    {{-- Seo --}}
                    @include('servers.includes.seo', ['model'=> $product ?? []])
                </div>
            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection