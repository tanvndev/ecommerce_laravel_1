@extends('layouts.serverLayout')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
            $('.date-range-picker').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: "Clear",
                },
            });

            $('.date-range-picker').on(
                "apply.daterangepicker",
                function (ev, picker) {
                    $(this).val(
                        picker.startDate.format("MM/DD/YYYY") +
                            " - " +
                            picker.endDate.format("MM/DD/YYYY")
                    );
                }
            );

            $('.date-range-picker').on(
                "cancel.daterangepicker",
                function (ev, picker) {
                    $(this).val("");
                }
            );
        });
</script>
@endsection

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['table']}}</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a href="{{route('user.create')}}" class="btn btn-primary btn-set-task w-sm-100">
                            <i class="icofont-plus-circle me-2 fs-6"></i>{{$config['seo']['create']}}</a>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row clearfix g-3">
            <div class="col-sm-12">

                <div class="card mb-2">
                    <div class="card-body ">
                        {{-- Filter --}}
                        @include('servers.orders.blocks.filter')
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body ">
                        <p class="mb-0 text-warning"><b>Lưu ý</b>: Tổng cuối chưa bao gồm mã giảm giá và các phí liên
                            quan.</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        @include('servers.orders.blocks.table', ['model' =>'Order'])
                        {{-- Pagination --}}
                        <div class="mt-3 pagination-list-text">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Row End -->

    </div>
</div>
@endsection