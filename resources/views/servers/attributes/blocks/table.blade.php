<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th style="width: 40%;">{{__('messages.attribute.table.name')}}</th>
            @include('servers.includes.languageTableTh')
            <th>{{__('messages.tableDisplayGroup')}}</th>
            <th style="width: 5%;">{{__('messages.tableOrder')}}</th>
            <th>{{__('messages.tableStatus')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attributes as $attribute) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$attribute->id}}" type="checkbox">
                </div>
            </td>
            <td>
                {{$attribute->name}}
            </td>
            @include('servers.includes.languageTableTd', ['model' => $attribute])
            <td>
                @foreach ($attribute->attribute_catalogues as $catalogue)
                @foreach ($catalogue->attribute_catalogue_language as $val)
                <a href="{{route('attribute.index', ['attribute_catalogue_id' => $catalogue->id])}}"
                    class="post-catalogue-name link-body-emphasis"> {{$val->name}}</a>
                @endforeach
                @endforeach
            </td>
            <td class="">
                {!! Form::text('order', $attribute->order, [
                'class' => 'form-control sort-order',
                'data-id' => $attribute->id,
                'data-model' => $modelName
                ]) !!}

            </td>

            <td>
                <div class="toggler toggler-list-check">
                    {!! Form::checkbox('publish', $attribute->publish, $attribute->publish == 1, ['id' =>
                    "publish-{$attribute->id}",
                    'class' => 'status', 'data-field' => 'publish', 'data-modelid' => $attribute->id, 'data-model' =>
                    $modelName]) !!}
                    <label for="publish-{{$attribute->id}}">
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
                    <a href="{{route('attribute.edit', $attribute->id)}}" class="btn btn-outline-secondary"><i
                            class="icofont-edit text-success"></i></a>
                    <button type="button" data-id="{{$attribute->id}}" class="btn btn-outline-secondary btn-delete"
                        data-bs-toggle="modal" data-bs-target="#modal-delete"><i
                            class="icofont-ui-delete text-danger"></i></a>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

@include('servers.includes.modalDelete', ['routeModalDelete' => 'attribute.destroy'])