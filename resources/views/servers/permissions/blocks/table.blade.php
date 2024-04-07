<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th>{{__('messages.permission.table.name')}}</th>
            <th>{{__('messages.tableCanonical')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($permissions as $permission) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$permission->id}}" type="checkbox">
                </div>
            </td>
            <td>
                <span> {{$permission->name}}</span>
            </td>
            <td>
                <span class="">{{$permission->canonical}}</span>
            </td>


            <td>
                <div class="btn-group" role="group">
                    <a href="{{route('permission.edit', $permission->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$permission->id}}" class="btn btn-outline-secondary btn-delete"
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
                <h6 class="fw-bold ">{{__('messages.deleteModalTitle')}}</h6>
                <p class="fs-13 mb-1 mt-3 ">{{__('messages.deleteModalDescription')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 "
                    data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
                {!! Form::open(['route' => 'permission.destroy', 'method' => 'delete']) !!}
                {!! Form::hidden('_id', null, ['id' => '_id']) !!}
                {!! Form::button(__('messages.agreeButton'), ['type' => 'submit', 'class' => 'btn btn-success text-white
                px-4 py-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>