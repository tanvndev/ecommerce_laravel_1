@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/servers/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{ asset('assets/servers/js/library/ckfinder_upload.js')}}"></script>

<script>
    // Lấy ra id của địa điểm để gán vào js
    var district_id = "{{isset($user->district_id) ? $user->district_id : old('district_id')}}";
    var ward_id = "{{isset($user->ward_id) ? $user->ward_id : old('ward_id') }}";
</script>

<script src="{{asset('assets/servers/js/library/location.js')}}"></script>

@endsection


@section('content')
@php
$user = isset($user) ? $user : null;
$url = $config['method'] == 'create' ? route('user.store') : route('user.update', $user->id);
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
                {{-- <div class="col-lg-4">
                    <div class="sticky-lg-top">
                        <div class="card mb-3">
                            <div
                                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                <h6 class="m-0 fw-bold">Visibility Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="couponsstatus" checked>
                                    <label class="form-check-label">
                                        Published
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="couponsstatus">
                                    <label class="form-check-label">
                                        Scheduled
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="couponsstatus">
                                    <label class="form-check-label">
                                        Hidden
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div
                                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                <h6 class="m-0 fw-bold">Publish Schedule</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-12">
                                        <label class="form-label">Publish Date</label>
                                        <input type="date" class="form-control w-100">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Publish Time</label>
                                        <input type="time" class="form-control w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div
                                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                <h6 class="m-0 fw-bold">Categories</h6>
                            </div>
                            <div class="card-body">
                                <label class="form-label">Parent category Select</label>
                                <select class="form-select" size="3" aria-label="size 3 select example">
                                    <option value="2">Clothes</option>
                                    <option value="3">Toy</option>
                                    <option value="4">Cosmetic</option>
                                    <option value="5">Laptop</option>
                                    <option value="6">Mobile</option>
                                    <option value="7">Watch</option>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header py-3 bg-transparent border-bottom-0">
                                <h6 class="m-0 fw-bold">Categories Image Upload</h6>
                                <small>With event and default file try to remove the image</small>
                            </div>
                            <div class="card-body">
                                <input type="file" id="dropify-event"
                                    data-default-file="assets/images/product/cropimg-upload.jpg') !!}">
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                                    <label class="form-label">Email <span class="text-danger">(*)</span></label>
                                    <input type="email" name="email" value="{{old('email', $user->email ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Họ tên <span class="text-danger">(*)</span></label>
                                    <input type="text" name="fullname"
                                        value="{{old('fullname', $user->fullname ?? '')}}" class="form-control">
                                </div>
                                @php
                                $catalogues = [
                                'Quản trị viên',
                                'Cộng tác viên'
                                ]
                                @endphp
                                <div class="col-md-6">
                                    <label class="form-label">Nhóm thành viên <span
                                            class="text-danger">(*)</span></label>
                                    <select class="form-select init-select2" name="user_catalogue_id">
                                        <option disabled selected>[Chọn nhóm thành viên]</option>
                                        @empty(!$catalogues)
                                        @foreach ($catalogues as $key => $catalogue)
                                        @php
                                        $key = $key+1;
                                        $selected = $key == old('user_catalogue_id', isset($user->user_catalogue_id) ?
                                        $user->user_catalogue_id : '') ? 'selected' : ''
                                        @endphp
                                        <option {{ $selected }} value="{{$key}}">{{$catalogue}}</option>

                                        @endforeach
                                        @endempty




                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="birthday"
                                        value="{{old('birthday', $user->birthday ?? '')}}" class="form-control">
                                </div>
                                @if (request()->routeIs('user.create'))
                                <div class="col-md-6">
                                    <label class="form-label">Mật khẩu <span class="text-danger">(*)</span></label>
                                    <input type="password" name="password" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nhập lại mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <input type="password" name="re_password" value="" class="form-control">
                                </div>

                                @endif
                                <div class="col-md-12">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input readonly type="text" data-type="Images" name="image" value=""
                                        class="form-control upload-image">
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thông tin liên hệ</h6>
                            <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">Tỉnh/Thành phố</label>
                                    <select class="form-select init-select2 locations provinces" name="province_id"
                                        data-target="districts">
                                        <option disabled selected>[Tỉnh/Thành phố]</option>
                                        @empty(!$provinces)

                                        @foreach ($provinces as $province )
                                        @php
                                        $selected = $province->code == old('province_id', isset($user->province_id) ?
                                        $user->province_id : '') ? 'selected' : ''
                                        @endphp
                                        <option {{$selected}} value="{{$province->code}}">{{$province->name}}</option>

                                        @endforeach
                                        @endempty
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Quận/Huyện</label>
                                    <select class="form-select init-select2 locations districts" name="district_id"
                                        data-target="wards">
                                        <option selected disabled>[Quận/Huyện]</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phường/Xã</label>
                                    <select class="form-select init-select2 wards" name="ward_id">
                                        <option selected>[Phường/Xã]</option>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="tel" name="phone" value="{{old('phone', $user->phone ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" value="{{old('address', $user->address ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Ghi chú</label>
                                    <input type="text" name="description"
                                        value="{{old('description', $user->description ?? '')}}" class="form-control">
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