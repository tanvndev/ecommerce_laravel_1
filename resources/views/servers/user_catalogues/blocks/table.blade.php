<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    <input class="form-check-input" type="checkbox" id="check-all">
                </div>
            </th>
            <th>{{__('messages.userCatalogue.table.name')}}</th>
            <th>{{__('messages.userCatalogue.table.countUser')}}</th>
            <th>{{__('messages.tableDescription')}}</th>
            <th>{{__('messages.tableStatus')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userCatalogues as $userCatalogue) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$userCatalogue->id}}" type="checkbox">
                </div>
            </td>

            <td>
                {{ $userCatalogue->name}}
            </td>
            <td>
                {{ $userCatalogue->users_count}} {{__('messages.person')}}
            </td>
            <td>
                {{ $userCatalogue->description}}
            </td>
            <td>
                <div class="toggler toggler-list-check">
                    <input class="status" id="publish-{{$userCatalogue->id}}" data-field="publish"
                        data-modelid="{{$userCatalogue->id}}" data-model="{{$model}}" name="publish" type="checkbox"
                        {{$userCatalogue->publish == 1 ? 'checked' : ''}} value="{{$userCatalogue->publish}}">
                    <label for="publish-{{$userCatalogue->id}}">
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
                    <a href="{{route('user.catalogue.edit', $userCatalogue->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$userCatalogue->id}}" class="btn btn-outline-secondary btn-delete"
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
                <form action="{{route('user.catalogue.destroy')}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="_id" id="_id">
                    <button type="submit"
                        class="btn btn-success text-white px-4 py-2">{{__('messages.agreeButton')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>