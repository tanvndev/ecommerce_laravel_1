<div class="row g-3 mb-3 row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 row-deck">
    <div class="col">
        <div class="card auth-detailblock">
            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                <h6 class="mb-0 fw-bold ">{{__('messages.order.detail.info')}}</h6>
                <a href="#" data-bs-toggle="modal" data-bs-target="#edit-order"
                    class="text-muted edit update-info-order">Chỉnh sửa</a>
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
        <div class="card auth-detailblock">
            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                <h6 class="mb-0 fw-bold ">{{__('messages.order.detail.address')}}</h6>
                <a href="#" data-bs-toggle="modal" data-bs-target="#edit-order"
                    class="text-muted edit update-info-order">Chỉnh
                    sửa</a>
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