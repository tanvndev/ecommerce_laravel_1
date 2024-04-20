@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{--
<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder.js')}}"></script> --}}
<script src="{{ asset('assets/servers/js/library/promotion.js')}}"></script>

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

                                {!! Form::select('', [__('messages.promotion.table.promotionType')] +
                                __('general.promotion'), '', ['class' => 'form-select init-select2 promotion-method'])
                                !!}

                            </div>
                            <div class="col-lg-12 promotion-container">
                                <div class="table-responsive rounded-1">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class=" text-end w-45">Sản phẩm mua</th>
                                                <th class=" text-end w-11">SL tối thiểu</th>
                                                <th class=" text-end ">Giới hạn KM</th>
                                                <th class=" text-end ">Chiết khấu</th>
                                                <th class=" text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="promotion-row-wrap">
                                            <tr class="promotion-type-row-item">
                                                <td class="">
                                                    <div class="product-quantity-wrap">
                                                        <div class="product-quantity-inner ">
                                                            <div class="goods-list d-none">
                                                                <div class="goods-item">
                                                                    <span>Macbook the he moi nhat h n n n</span>
                                                                    <button type="button" class="btn-close"></button>
                                                                </div>
                                                                <div class="goods-item last-child">
                                                                    Tìm theo tên, mã sản phẩm...
                                                                </div>
                                                            </div>
                                                            <div class="search-wrap" data-bs-toggle="modal"
                                                                data-bs-target="#find-product">
                                                                <div class="icon-search ">
                                                                    <i class="icofont-search-1"></i>
                                                                </div>
                                                                <div class="input-search">
                                                                    <p>Tìm theo tên, mã sản phẩm...</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td class="">
                                                    <input type="text" name="amountTo[]"
                                                        class="form-control text-end int" value="1">
                                                </td>
                                                <td class="">
                                                    <input type="text" name="amountTo[]"
                                                        class="form-control text-end int" value="0">
                                                </td>
                                                <td class="discount-type">
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" name="amountValue[]"
                                                            class="form-control text-end int me-1 " value="0">

                                                        <select class="form-select init-select2 w-25 "
                                                            name="amountType[]">
                                                            <option value="cast">đ</option>
                                                            <option value="percent">%</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary delete-promotion-type-row text-danger px-2">
                                                        <i class="icofont-trash fs-14 "></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div><!-- Row end  -->

        </div>
    </div>
    {!! Form::close() !!}
    <input type="hidden" name="select_product_and_quantity"
        value="{{json_encode(__('general.promotion_select_product_and_quantity'))}}">
    @include('servers.promotions.blocks.popup')
</div>
@endsection