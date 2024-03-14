@extends('layouts.serverLayout')




@section('content')
@php
$url = $config['method'] == 'create' ? route('user.catalogue.store') : route('user.catalogue.update',
$userCatalogue->id);
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
                <div class="col-lg-10">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thông tin chung</h6>
                            <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">Tên nhóm thành viên <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{old('name', $userCatalogue->name ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mô tả</label>
                                    <input type="text" name="description"
                                        value="{{old('description', $userCatalogue->description ?? '')}}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection