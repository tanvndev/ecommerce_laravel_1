<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    <input class="form-check-input" type="checkbox" id="check-all">
                </div>
            </th>
            <th>Tiêu đề bài viết</th>
            <th>Nhóm hiện thị</th>
            <th>Vị trí</th>
            <th>Tình trạng</th>
            <th>Thực thi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$post->id}}" type="checkbox">
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center justify-content-start">
                    <img class="avatar image-post rounded" src="{{$post->image}}" alt="{{$post->name}}">
                    <a href="" class="fw-bold link-body-emphasis ms-2 "> {{$post->name}}</a>

                </div>
            </td>
            <td>
                @foreach ($post->post_catalogues as $catalogue)
                @foreach ($catalogue->post_catalogue_language as $val)
                <a href="{{route('post.index', ['post_catalogue_id' => $catalogue->id])}}"
                    class="post-catalgue-name link-body-emphasis"> {{$val->name}}</a>
                @endforeach
                @endforeach
            </td>
            <td class="">
                <input type="text" class="form-control sort-order w-25" name="order" data-id="{{$post->id}}"
                    data-model="{{$model}}" value="{{$post->order}}" />
            </td>

            <td>
                <div class="toggler toggler-list-check">
                    <input class="status" id="publish-{{$post->id}}" data-field="publish" data-modelid="{{$post->id}}"
                        data-model="{{$model}}" name="publish" type="checkbox" {{$post->publish ==
                    1 ? 'checked' :
                    ''}}
                    value="{{$post->publish}}">
                    <label for="publish-{{$post->id}}">
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
                    <a href="{{route('post.edit', $post->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$post->id}}" class="btn btn-outline-secondary btn-delete"
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
                <form action="{{route('post.destroy')}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="_id" id="_id">
                    <button type="submit" class="btn btn-success text-white px-4 py-2">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
</div>