<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th>{{__('messages.attributeCatalogue.table.name')}}</th>
            @include('servers.includes.languageTableTh')
            <th>{{__('messages.tableStatus')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attributeCatalogues as $attributeCatalogue) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$attributeCatalogue->id}}" type="checkbox">
                </div>
            </td>
            <td>
                {{str_repeat('|-----', (($attributeCatalogue->level > 0) ? ($attributeCatalogue->level - 1) :
                0)).$attributeCatalogue->name}}
            </td>
            @include('servers.includes.languageTableTd', ['model' => $attributeCatalogue])
            <td>
                <div class="toggler toggler-list-check">
                    {!! Form::checkbox('publish', $attributeCatalogue->publish, $attributeCatalogue->publish == 1, ['id'
                    => "publish-{$attributeCatalogue->id}",
                    'class' => 'status', 'data-field' => 'publish', 'data-modelid' => $attributeCatalogue->id,
                    'data-model' =>
                    $modelName]) !!}
                    <label for="publish-{{$attributeCatalogue->id}}">
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
                    <a href="{{route('attribute.catalogue.edit', $attributeCatalogue->id)}}"
                        class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$attributeCatalogue->id}}"
                        class="btn btn-outline-secondary btn-delete" data-bs-toggle="modal"
                        data-bs-target="#modal-delete"><i class="icofont-ui-delete text-danger"></i></a>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

@include('servers.includes.modalDelete', ['routeModalDelete' => 'attribute.catalogue.destroy'])