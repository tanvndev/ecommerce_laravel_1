@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>Thông tin Thu nhập - <span class="fw-bold text-primary">{{ $user['fullname'] }}</span></h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Tổng chi</h5>
                                <h3 class="card-text">{{ number_format($income['total_commission'], 0, ',', '.') }} đ
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <h5>Chi tiết hoa hồng</h5>
                @if(count($income['commission_details']) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên</th>
                                <th>Số tiền hoa hồng</th>
                                <th>Cấp</th>
                                <th>Ngày nhận</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($income['commission_details'] as $commission)
                            <tr>
                                <td>#{{ $commission['order_code'] }}</td>
                                <td>{{ $commission['user_name'] }}</td>
                                <td>{{ number_format($commission['amount'], 0, ',', '.') }} đ</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $commission['level'] == 1 ? 'primary' : ($commission['level'] == 2 ? 'success' : 'warning') }}">
                                        Cấp {{ $commission['level'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($commission['created_at'])->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    Chưa có hoa hồng nào được ghi nhận.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
