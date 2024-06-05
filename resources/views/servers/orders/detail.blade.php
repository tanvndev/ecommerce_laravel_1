@extends('layouts.serverLayout')

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}: #{{$order->code}}</h3>
                    {{-- <div class="col-auto d-flex btn-set-task w-sm-100 align-items-center">
                        <select class="form-select" aria-label="Default select example">
                            <option selected="">Select Order Id</option>
                            <option value="1">Order-78414</option>
                            <option value="2">Order-78415</option>
                            <option value="3">Order-78416</option>
                            <option value="4">Order-78417</option>
                            <option value="5">Order-78418</option>
                            <option value="6">Order-78419</option>
                            <option value="7">Order-78420</option>
                        </select>
                    </div> --}}
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
            <div class="col">
                <div class="alert-success alert mb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i></div>
                        <div class="flex-fill ms-3 text-truncate">
                            <div class="h6 mb-0">{{__('messages.order.table.create_at')}}</div>
                            <span class="small">{{$order->created_at->format('d/m/Y H:i:s')}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="alert-danger alert mb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-user fa-lg"
                                aria-hidden="true"></i></div>
                        <div class="flex-fill ms-3 text-truncate">
                            <div class="h6 mb-0">{{__('messages.fullname')}}</div>
                            <span class="small">{{$order->fullname}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="alert-warning alert mb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-envelope fa-lg"
                                aria-hidden="true"></i></div>
                        <div class="flex-fill ms-3 text-truncate">
                            <div class="h6 mb-0">Email</div>
                            <span class="small">{{$order->email}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="alert-info alert mb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-phone-square fa-lg"
                                aria-hidden="true"></i></div>
                        <div class="flex-fill ms-3 text-truncate">
                            <div class="h6 mb-0">{{__('messages.phone')}}</div>
                            <span class="small">{{$order->phone}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row g-3 mb-3 row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 row-deck">
            <div class="col">
                <div class="card auth-detailblock">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.order.detail.info')}}</h6>
                        <a href="#" class="text-muted">Chỉnh sửa</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.code')}}:</label>
                                <span><strong>{{$order->code}}</strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.fullname')}}:</label>
                                <span><strong>{{$order->fullname}}</strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.phone')}}:</label>
                                <span><strong>{{$order->phone}}</strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.email')}}:</label>
                                <span><strong>{{$order->email}}</strong></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.order.detail.address')}}</h6>
                        <a href="#" class="text-muted">Chỉnh sửa</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.cities')}}:</label>
                                <span><strong>{{ $order->province_name }}</strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.districts')}}:</label>
                                <span><strong> {{ $order->district_name }} </strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.wards')}}:</label>
                                <span><strong>{{ $order->ward_name }}</strong></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label col-6 col-sm-5">{{__('messages.address')}}:</label>
                                <span><strong>{{$order->address}}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row g-3 mb-3">
            <div class="col-xl-12 col-xxl-8">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">Tóm tắt đơn hàng</h6>
                    </div>
                    <div class="card-body">
                        <div class="product-cart">
                            <div class="checkout-table">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table
                                            class="table display table-hover align-middle nowrap no-footer dtr-inline"
                                            style="width: 100%;" role="grid">
                                            <thead>
                                                <tr role="row">
                                                    <th width="40%">
                                                        Sản phẩm
                                                    </th>
                                                    <th>
                                                        Số lượng
                                                    </th>
                                                    <th>
                                                        Giá bán
                                                    </th>
                                                    <th>
                                                        Giá khuyến mãi
                                                    </th>
                                                    <th>
                                                        Thành tiến
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->cart['detail'] as $item)
                                                @php
                                                $option = $item['options'][0]
                                                @endphp
                                                <tr role="row" class="odd">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{$option['image']}}" class="avatar rounded lg "
                                                                alt="Product">
                                                            <h6 class="title mb-0 ms-2">{{$item['name']}}</h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{$item['qty']}}
                                                    </td>
                                                    <td>
                                                        <p class="price">{{formatCurrency($option['originalPrice'])}}
                                                        </p>

                                                    </td>
                                                    <td>
                                                        <p class="price">{{formatCurrency($item['price'])}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="price">{{formatCurrency($item['price'] +
                                                            $item['qty'])}}</p>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="myCartTable_info" role="status"
                                            aria-live="polite">Showing 1 to 4 of 4 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="myCartTable_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="myCartTable_previous"><a href="#" aria-controls="myCartTable"
                                                        data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                                <li class="paginate_button page-item active"><a href="#"
                                                        aria-controls="myCartTable" data-dt-idx="1" tabindex="0"
                                                        class="page-link">1</a></li>
                                                <li class="paginate_button page-item next disabled"
                                                    id="myCartTable_next"><a href="#" aria-controls="myCartTable"
                                                        data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="checkout-coupon-total checkout-coupon-total-2 d-flex flex-wrap justify-content-end">
                                <div class="checkout-total">
                                    <div class="single-total">
                                        <p class="value">Tạm tính:</p>
                                        <p class="price">{{ formatCurrency($order->cart['total']) }}</p>
                                    </div>
                                    <div class="single-total">
                                        <p class="value">Phí vận chuyển (+):</p>
                                        <p class="price">Miễn phí</p>
                                    </div>
                                    <div class="single-total">
                                        <p class="value">Mã giảm giá (-):</p>
                                        <p class="price">{{formatCurrency($order->promotion['discount'])}}</p>
                                    </div>
                                    {{-- <div class="single-total">
                                        <p class="value">Tax(18%):</p>
                                        <p class="price">$198.00</p>
                                    </div> --}}
                                    <div class="single-total total-payable">
                                        <p class="value">Tổng:</p>
                                        <p class="price">{{formatCurrency($order->cart['total'] -
                                            $order->promotion['discount'])}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-xxl-4">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">{{__('messages.order.table.status')}}</h6>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                    <label class="form-label">{{__('messages.code')}}</label>
                                    <input type="text" readonly class="form-control" value="{{$order->code}}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Order Status</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="1">Progress</option>
                                        <option value="2">Completed</option>
                                        <option selected="" value="3">Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Order Transection</label>
                                    <select class="form-select" aria-label="Transection">
                                        <option value="1">Completed</option>
                                        <option value="2">Fail</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="comment" class="form-label">{{__('messages.notes')}}</label>
                                    <textarea class="form-control" id="comment"
                                        rows="4">{{$order->description}}</textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-4 text-uppercase">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
    </div>
</div>

@endsection