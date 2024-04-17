<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th>Tên nhóm</th>
            <th>Từ khoá</th>
            <th>Danh sách hình ảnh</th>
            <th>{{__('messages.tableStatus')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($slides as $slide) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$slide->id}}" type="checkbox">
                </div>
            </td>
            <td>
                {{$slide->name}}
            </td>
            <td class="">
                {{$slide->keyword}}
            </td>
            <td class="">
                <div id="sortable-slide" class="d-flex align-items-center gx-3 " data-id="{{$slide->id}}">
                    @foreach ($slide->item[1] as $item)
                    <div class="p-1 rounded-2 sortable-item">
                        <img class="img-thumbnail image-slide-table" src="{{$item['image']}}" alt="{{$slide->name}}">
                        <input type="hidden" name="image[]" value="{{$item['image']}}">
                    </div>
                    @endforeach
                </div>
            </td>

            <td>
                <div class="toggler toggler-list-check">
                    {!! Form::checkbox('publish', $slide->publish, $slide->publish == 1, ['id' =>
                    "publish-{$slide->id}",
                    'class' => 'status', 'data-field' => 'publish', 'data-modelid' => $slide->id, 'data-model' =>
                    $modelName]) !!}
                    <label for="publish-{{$slide->id}}">
                        <svg class="toggler-on" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 130.2 130.2">
                            <polyline class="path check" points="100.2,40.2 51.5,88.8 29.8,67.5"></polyline>
                        </svg>
                        <svg class="toggler-off" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 130.2 130.2">
                            <line class="path line" x1="34.4" y1="34.4" x2="95.8" y2="95.8"></line>
                            <line class="path line" x1="95.8" y1="34.4" x2="34.4" y2="95.8"></line>
                        </svg>
                    </label>
                </div>
            </td>

            <td>
                <div class="btn-group" role="group">
                    <a href="{{route('slide.edit', $slide->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$slide->id}}" class="btn btn-outline-secondary btn-delete"
                        data-bs-toggle="modal" data-bs-target="#modal-delete"><i
                            class="icofont-ui-delete text-danger"></i></a>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

@include('servers.includes.modalDelete', ['routeModalDelete' => 'slide.destroy'])