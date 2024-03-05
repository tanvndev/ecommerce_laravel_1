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
                    <img class="avatar rounded border" src="{{asset('assets/servers/images/xs/avatar1.svg')}}" alt="">
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
                            <polyline class="path check" points="100.2,40.2 51.5,88.8 29.8,67.5"></polyline>
                        </svg>
                        <svg class="toggler-off" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 130.2 130.2">
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
                    <a href="{{route('user.edit', $user->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" class="btn btn-outline-secondary deleterow"><i
                            class="icofont-ui-delete text-danger"></i></button>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>