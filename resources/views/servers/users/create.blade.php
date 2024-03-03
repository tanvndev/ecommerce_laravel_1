@extends('layouts.serverLayout')

@section('content')
<form action="" method="post">
    <div class="body d-flex py-3">

        <div class="container-xxl">

            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Thêm thông tin người dùng</h3>
                        <button type="submit" class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">Tạo
                            mới</button>
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
                    <div class="card mb-3">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thông tin chung</h6>
                            <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">(*)</span></label>
                                    <input type="email" name="email" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Họ tên <span class="text-danger">(*)</span></label>
                                    <input type="text" name="fullname" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nhóm thành viên <span
                                            class="text-danger">(*)</span></label>
                                    <select class="form-select">
                                        <option selected>[Chọn nhóm thành viên]</option>
                                        <option value="3">Toy</option>
                                        <option value="4">Cosmetic</option>
                                        <option value="5">Laptop</option>
                                        <option value="6">Mobile</option>
                                        <option value="7">Watch</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="birthday" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mật khẩu <span class="text-danger">(*)</span></label>
                                    <input type="password" name="password" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nhập lại mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <input type="password" name="re_password" value="" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" name="re_password" value="" class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thông tin liên hệ</h6>
                            <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">Tỉnh/Thành phố <span
                                            class="text-danger">(*)</span></label>
                                    <select class="form-select">
                                        <option selected>[Tỉnh/Thành phố]</option>
                                        <option value="3">Toy</option>
                                        <option value="4">Cosmetic</option>
                                        <option value="5">Laptop</option>
                                        <option value="6">Mobile</option>
                                        <option value="7">Watch</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Quận/Huyện <span class="text-danger">(*)</span></label>
                                    <select class="form-select">
                                        <option selected>[Quận/Huyện]</option>
                                        <option value="3">Toy</option>
                                        <option value="4">Cosmetic</option>
                                        <option value="5">Laptop</option>
                                        <option value="6">Mobile</option>
                                        <option value="7">Watch</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phường/Xã <span class="text-danger">(*)</span></label>
                                    <select class="form-select">
                                        <option selected>[Phường/Xã]</option>
                                        <option value="3">Toy</option>
                                        <option value="4">Cosmetic</option>
                                        <option value="5">Laptop</option>
                                        <option value="6">Mobile</option>
                                        <option value="7">Watch</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại <span class="text-danger">(*)</span></label>
                                    <input type="tel" name="birthday" value="" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="password" name="password" value="" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Ghi chú</label>
                                    <input type="password" name="re_password" value="" class="form-control">
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