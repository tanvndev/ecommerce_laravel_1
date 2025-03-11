@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Danh sách Thành viên đa cấp - {{ $user['fullname'] }}</h4>
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
        </div>
        @else
        <div class="alert alert-info">
            Không có thành viên nào trong hệ thống của bạn.
        </div>
        @endif
    </div>
</div>
@endsection
