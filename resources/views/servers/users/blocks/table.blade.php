<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    <input class="form-check-input" type="checkbox" id="check-all">
                </div>
            </th>
            <th>Tên thành viên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Nhóm thành viên</th>
            <th>Tình trạng</th>
            <th>Thực thi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$user->id}}" type="checkbox">
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center justify-content-start  ">
                    <img class="avatar rounded" src="{{$user->image}}" alt="{{$user->fullname}}">
                    <span class="fw-bold ms-1"> {{$user->fullname}}</span>
                </div>
            </td>


            <td>
                {{$user->email}}
            </td>
            <td>
                {{$user->phone}}
            </td>
            <td>
                {{$user->address}}
            </td>
            <td>
                {{$user->user_catalogues->name}}
            </td>
            <td>
                <div class="toggler toggler-list-check">
                    <input class="status" id="publish-{{$user->id}}" data-field="publish" data-modelid="{{$user->id}}"
                        data-model="User" name="publish" type="checkbox" {{$user->publish ==
                    1 ? 'checked' :
                    ''}}
                    value="{{$user->publish}}">
                    <label for="publish-{{$user->id}}">
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
                    <button type="button" data-id="{{$user->id}}" class="btn btn-outline-secondary btn-delete"
                        data-bs-toggle="modal" data-bs-target="#modal-delete"><i
                            class="icofont-ui-delete text-danger"></i></a>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

<div class="modal fade modal-custom-delete p-3 " id="modal-delete" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center align-item-center ">
                <div class="pt-4 ">
                    <i class="fs-3  icofont-ui-delete text-danger"></i>
                </div>
            </div>
            <div class="modal-body text-center ">
                <h6 class="fw-bold ">Bạn có chắc không! Muốn xóa bản ghi này?
                </h6>
                <p class="fs-13 mb-1 mt-3 ">Bạn có thực sự muốn xóa những bản ghi này? Bạn không thể khôi phục bản ghi
                    trong
                    danh
                    sách của mình nữa nếu bạn xóa!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 " data-bs-dismiss="modal">Huỷ
                    bỏ</button>
                <form action="{{route('user.destroy')}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="_id" id="_id">
                    <button type="submit" class="btn btn-success text-white px-4 py-2">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
</div>