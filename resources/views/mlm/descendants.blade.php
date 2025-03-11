@extends('layouts.app')

@section('content')
<script src="{{ asset('assets/servers/bundles/apexcharts.bundle.js')}}"></script>
<div class="card">
    <div class="card-header">
        <h4>Danh sách Thành viên đa cấp - <span class="text-primary fw-bold">{{ $user['fullname'] }}</span></h4>
        <a href="{{ route('mlm.income', request()->userId) }}">Thu nhập</a>
    </div>
    <div class="card-body">
        @if(count($descendants) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Cấp</th>
                        <th>Doanh số</th>
                        <th width="200">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descendants as $member)
                    <tr>
                        <td>{{ $member['id'] }}</td>
                        <td style="padding-left: {{ ($member['level'] - 1) * 20 }}px">
                            @if($member['level'] > 1)
                            <i class="fas fa-arrow-from-left me-2"></i>
                            @endif
                            {{ $member['name'] }}
                        </td>
                        <td>
                            <span
                                class="badge bg-{{ $member['level'] == 1 ? 'primary' : ($member['level'] == 2 ? 'success' : 'warning') }}">
                                Cấp {{ $member['level'] }}
                            </span>
                        </td>
                        <td>{{ number_format($member['total_sales'], 0, ',', '.') }} đ</td>
                        <td>
                            <a href="{{ url('/mlm/income/' . $member['id']) }}" class="btn btn-sm btn-info text-white">
                                Thu nhập
                            </a>

                            <a href="{{ url('/mlm/descendants/' . $member['id']) }}"
                                class="btn btn-sm btn-primary text-white">
                                Thành viên
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card">
                <div
                    class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Doanh thu bình quân</h6>
                </div>
                <div class="card-body">
                    <div class="h2 mb-0">{{ number_format(collect($descendants)->average('total_sales'), 0, ',', '.')
                        }}đ</div>
                    <span class="text-muted small">Doanh thu bình quân của tất cả thành viên</span>
                    <div id="apex-expense"></div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            Không có thành viên nào trong hệ thống của bạn.
        </div>
        @endif
    </div>
</div>


<script>
    $(document).ready(function() {
        var options = {
            series: [{
                name: 'Doanh số',
                data: {!! json_encode(collect($descendants)->map(function($member) { return $member['total_sales']; })) !!}
            }],
            chart: {
                height: 315,
                type: 'bar',
                toolbar: {
                    show: false,
                },
            },
            colors: ['#4CAF50'],
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top',
                    },
                    columnWidth: '60%',
                    borderRadius: 4,
                    gradient: {
                        type: "vertical",
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        colorStops: [
                            {
                                offset: 0,
                                color: "#4CAF50",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "#81C784",
                                opacity: 1
                            }
                        ]
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                        maximumFractionDigits: 0
                    }).format(val);
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ['#2E7D32'],
                }
            },
            xaxis: {
                categories: {!! json_encode(collect($descendants)->map(function($member) { return $member['name']; })) !!},
                position: 'bottom',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                tooltip: {
                    enabled: true,
                },
                labels: {
                    rotate: -45,
                    style: {
                        fontSize: '12px',
                        colors: '#333333'
                    }
                }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: true,
                    style: {
                        colors: '#333333'
                    },
                    formatter: function (val) {
                        return new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND',
                            maximumFractionDigits: 0
                        }).format(val);
                    }
                }
            },
            theme: {
                mode: 'light'
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-expense"), options);
        chart.render();
    });


</script>
@endsection
