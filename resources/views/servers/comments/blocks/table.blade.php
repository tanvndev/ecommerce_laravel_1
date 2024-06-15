<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}

                </div>
            </th>
            <th>{{__('messages.comment.table.fullname')}}</th>
            <th>{{__('messages.email')}}</th>
            <th>{{__('messages.phone')}}</th>
            <th>{{__('messages.comment.table.created_at')}}</th>
            <th>{{__('messages.comment.table.star')}}</th>
            <th width="30%">{{__('messages.content')}}</th>
            <th>{{__('messages.tableStatus')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $comment) <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$comment->id}}" type="checkbox">
                </div>
            </td>
            <td>
                {{$comment->fullname}}
            </td>
            <td>
                {{$comment->email}}
            </td>
            <td>
                {{$comment->phone}}
            </td>
            <td>
                {{convertDateTime($comment->created_at)}}
            </td>
            <td>
                <div class="d-flex align-items-center">
                    {!!generateStarPercent($comment->rate)!!}
                    <span class="ms-2">({{$comment->rate}})</span>
                </div>
            </td>
            <td>
                {{$comment->description}}
            </td>
            <td>
                <div class="toggler toggler-list-check">
                    {!! Form::checkbox('publish', $comment->publish, $comment->publish == 1, ['id' =>
                    "publish-{$comment->id}",
                    'class' => 'status', 'data-field' => 'publish', 'data-modelid' => $comment->id, 'data-model' =>
                    $modelName]) !!}
                    <label for="publish-{{$comment->id}}">
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

        </tr>
        @endforeach

    </tbody>

</table>