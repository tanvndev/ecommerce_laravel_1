@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{asset('assets/servers/plugin/nice-select/nice-select.css')}}" rel="stylesheet" />

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/servers/plugin/nice-select/jquery.nice-select.min.js') }}"></script>

<script>
    // Lấy ra id của địa điểm để gán vào js
    var district_id = "{{old('district_id', $order->district_id)}}";
    var ward_id = "{{old('ward_id', $order->ward_id)}}";
</script>
<script src="{{ asset('assets/servers/js/library/order.js')}}"></script>
<script src="{{asset('assets/servers/js/library/location.js')}}"></script>
@endsection
@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}: #{{$order->code}}</h3>

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

        {{-- Error --}}
        @include('servers.includes.messageError')
        {{-- End Error --}}

        {{-- Address --}}
        @include('servers.orders.blocks.address')
        {{-- End Address --}}

        <div class="row g-3 mb-3">
            {{-- Summary --}}
            @include('servers.orders.blocks.summary')
            {{-- End Summary --}}

            {{-- Status --}}
            @include('servers.orders.blocks.status')
            {{-- End Status --}}
        </div> <!-- Row end  -->
    </div>
</div>
@include('servers.orders.blocks.editModal')

@endsection