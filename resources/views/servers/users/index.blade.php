@extends('layouts.serverLayout')

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Thông tin thành viên</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a href="{{route('user.create')}}" class="btn btn-primary btn-set-task w-sm-100">
                            <i class="icofont-plus-circle me-2 fs-6"></i>Thêm mới thành viên </a>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="" class="form-list-filter">
                            <div class="row">
                                <div class="col-lg-2 ">
                                    <div class="mb-3">
                                        <select class="form-select " name="" id="">
                                            <option selected value="">10 bản ghi</option>
                                            <option value="">20 bản ghi</option>
                                            <option value="">40 bản ghi</option>
                                            <option value="">100 bản ghi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-10 ">
                                    <div class="row ">
                                        <div class="col">
                                            <div class="mb-3">
                                                <select class="form-select " name="" id="">
                                                    <option selected value="">10 bản ghi</option>
                                                    <option value="">20 bản ghi</option>
                                                    <option value="">40 bản ghi</option>
                                                    <option value="">100 bản ghi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <select class="form-select " name="" id="">
                                                    <option selected value="">10 bản ghi</option>
                                                    <option value="">20 bản ghi</option>
                                                    <option value="">40 bản ghi</option>
                                                    <option value="">100 bản ghi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 d-flex ">
                                                <div class="w-75 ">
                                                    <input type="text" class="form-control" name=""
                                                        placeholder="Tìm kiếm..." />
                                                </div>
                                                <div class="ms-2 w-25 ">
                                                    <button type="submit" class="btn btn-success w-100 text-white ">Tìm
                                                        kiếm</button>
                                                </div>
                                            </div>

                                        </div>




                                    </div>

                                </div>
                            </div>
                        </form>
                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="fs-15">
                                        <div class="form-check form-table-list-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th>Ảnh</th>
                                    <th>Thông tin thành viên</th>
                                    <th>Địa chỉ</th>
                                    <th>Tình trạng</th>
                                    <th>Thực thi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user) <tr>
                                    <td>
                                        <div class="form-check form-table-list-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="customer-detail.html">
                                            <img class="avatar rounded border"
                                                src="{{asset('assets/servers/images/xs/avatar1.svg')}}" alt="">
                                            {{-- <span class="fw-bold ms-1">Joan Dyer</span> --}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="table-list-info">
                                            <p><strong>Họ tên:</strong> {{$user->fullname}}</p>
                                            <p><strong>Email:</strong> {{$user->email}}</p>
                                            <p><strong>Số điện thoại:</strong> {{$user->phone}}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-list-info">
                                            <p><strong>Địa chỉ:</strong> {{$user->address}}</p>
                                            <p><strong>Phường:</strong> 0332225690</p>
                                            <p><strong>Quận:</strong> 0332225690</p>
                                            <p><strong>Thành phố:</strong> 0332225690</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggler toggler-list-check">
                                            <input id="toggler-1" checked name="toggler-1" type="checkbox" value="1">
                                            <label for="toggler-1">
                                                <svg class="toggler-on" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 130.2 130.2">
                                                    <polyline class="path check"
                                                        points="100.2,40.2 51.5,88.8 29.8,67.5"></polyline>
                                                </svg>
                                                <svg class="toggler-off" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                                    <line class="path line" x1="34.4" y1="34.4" x2="95.8" y2="95.8">
                                                    </line>
                                                    <line class="path line" x1="95.8" y1="34.4" x2="34.4" y2="95.8">
                                                    </line>
                                                </svg>
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#expedit"><i
                                                    class="icofont-edit text-success"></i></button>
                                            <button type="button" class="btn btn-outline-secondary deleterow"><i
                                                    class="icofont-ui-delete text-danger"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="mt-3 pagination-list-text">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Row End -->

    </div>
</div>
@endsection