<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th>{{__('messages.promotion.table.name')}}</th>
            <th class="text-center ">{{__('messages.promotion.table.discount')}}</th>
            <th>{{__('messages.promotion.table.promotionMethod')}}</th>
            <th>{{__('messages.startDate')}}</th>
            <th>{{__('messages.endDate')}}</th>
            <th>{{__('messages.tableStatus')}}</th>
            <th>{{__('messages.tableAction')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($promotions as $promotion) <tr>
            @php
            $status = '';
            if (empty($promotion->never_end) && $promotion->end_at < date('Y-m-d H:i:s')) {
                $status="<span class='text-danger fw-bold fs-12 '>" . '- ' . __('messages.expired') .'</span>';
                }
                @endphp
                <td>
                    <div class="form-check form-table-list-check">
                        <input class="form-check-input check-item" value="{{$promotion->id}}" type="checkbox">
                    </div>
                </td>
                <td>
                    <div class="position-relative ">
                        {{$promotion->name}}
                        {!!$status!!}
                    </div>
                    <span class="d-block text-success fw-bold fs-12 mt-1"> {{__('messages.code')}}:
                        {{$promotion->code}}</span>
                </td>
                <td class="text-center ">
                    {!!renderDiscountInfomation($promotion)!!}
                </td>

                <td>
                    {{__('general.promotion')[$promotion->method] ?? '-'}}
                </td>
                <td>
                    {{convertDateTime($promotion->start_at)}}
                </td>
                <td>
                    @if (!empty($promotion->never_end))
                    <span class="text-success">Không kết thúc </span>
                    @else
                    {{convertDateTime($promotion->end_at)}}
                    @endif
                </td>

                <td>
                    <div class="toggler toggler-list-check">
                        {!! Form::checkbox('publish', $promotion->publish, $promotion->publish == 1, ['id' =>
                        "publish-{$promotion->id}",
                        'class' => 'status', 'data-field' => 'publish', 'data-modelid' => $promotion->id, 'data-model'
                        =>
                        $modelName]) !!}
                        <label for="publish-{{$promotion->id}}">
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
                        <a href="{{route('promotion.edit', $promotion->id)}}" class="btn btn-outline-secondary"><i
                                class="icofont-edit text-success"></i></a>
                        <button type="button" data-id="{{$promotion->id}}" class="btn btn-outline-secondary btn-delete"
                            data-bs-toggle="modal" data-bs-target="#modal-delete"><i
                                class="icofont-ui-delete text-danger"></i></a>
                    </div>
                </td>
        </tr>
        @endforeach

    </tbody>

</table>

@include('servers.includes.modalDelete', ['routeModalDelete' => 'promotion.destroy'])