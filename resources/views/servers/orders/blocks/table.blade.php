<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
    <thead>
        <tr>
            <th class="fs-15">
                <div class="form-check form-table-list-check">
                    {!! Form::checkbox('check-all', null, null, ['class' => 'form-check-input', 'id' => 'check-all'])
                    !!}
                </div>
            </th>
            <th>{{__('messages.code')}}</th>
            <th>{{__('messages.created')}} đơn</th>
            <th>{{__('messages.customerInfo')}}</th>
            <th>{{__('messages.discount')}}</th>
            <th>{{__('messages.shipping')}}</th>
            <th>{{__('messages.endTotal')}}</th>
            <th>{{__('messages.status')}}</th>
            <th>{{__('messages.payment')}}</th>
            <th>{{__('messages.delivery')}}</th>
            <th>{{__('messages.paymentMethod')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr class="order-item-tr" data-order-id="{{$order->id}}">
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$order->id}}" type="checkbox">
                </div>
            </td>

            <td>
                <span class="text-primary fw-bold"> #<a class="text-primary fw-bold link-body-emphasis"
                        href="{{route('order.detail', ['id' => $order->id])}}">{{$order->code}}</a></span>
            </td>
            <td>
                {{ convertDateTime($order->created_at, 'H:i d/m/Y') }}
            </td>
            <td>
                <div class="mb-1"><b>N: </b>{{$order->fullname}}</div>
                <div class="mb-1"><b>P: </b>{{$order->phone}}</div>
                <div class="mb-1 addess-table"><b>A: </b>{{$order->address}}</div>
            </td>


            <td>
                <span class="fw-bold">{{formatCurrency($order->promotion['discount'])}}</span>
            </td>
            <td>
                <span class="fw-bold">{{formatCurrency($order->shipping)}}</span>
            </td>
            <td>
                <span class="fw-bold">{{formatCurrency($order->cart['total'])}}</span>
            </td>
            <td>
                {!! renderOrderStatusDropdown($order, 'confirm') !!}
            </td>
            <td>
                {!! renderOrderStatusDropdown($order, 'payment') !!}
            </td>
            <td>
                {!! renderOrderStatusDropdown($order, 'delivery') !!}
            </td>

            <td>
                <img class="img-contain" width="50px"
                    src="{{ array_column(__('payment.method'), 'image', 'name')[$order->payment_method] }}" alt="">
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

{{-- @include('servers.includes.modalDelete', ['routeModalDelete' => 'order.destroy']) --}}