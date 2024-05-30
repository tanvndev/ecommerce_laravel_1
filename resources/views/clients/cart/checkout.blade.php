@extends('layouts.clientLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/servers/js/library/location.js') }}"></script>

<script>
    // Lấy ra id của địa điểm để gán vào js
    var district_id = "{{isset($order->district_id) ? $order->district_id : old('district_id')}}";
    var ward_id = "{{isset($order->ward_id) ? $order->ward_id : old('ward_id') }}";

    if ($('.init-select2').length > 0) {
        $('.init-select2').select2();
    }
</script>


@endsection

@section('content')
<section class="main-wrapper">
    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">
            {!! Form::open() !!}
            <div class="row">
                <div class="col-lg-6">
                    @include('clients.cart.blocks.infomation')
                </div>
                <div class="col-lg-6">
                    @include('clients.cart.blocks.orderList')
                </div>
            </div>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- End Checkout Area  -->

</section>
@endsection