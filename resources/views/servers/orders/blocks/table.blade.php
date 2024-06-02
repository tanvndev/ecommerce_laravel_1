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
            <th>{{__('messages.created')}}</th>
            <th>{{__('messages.customerInfo')}}</th>
            <th>{{__('messages.paymentMethod')}}</th>
            <th>{{__('messages.discount')}}</th>
            <th>{{__('messages.shipping')}}</th>
            <th>{{__('messages.endTotal')}}</th>
            <th>{{__('messages.payment')}}</th>
            <th>{{__('messages.delivery')}}</th>
            <th>{{__('messages.status')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        @php
        $statusPayment = $order->payment == 'unpaid' ? 'danger' : 'success';

        switch ($order->delivery) {
        case 'pending':
        $statusDelivery = 'warning';
        break;
        case 'processing':
        $statusDelivery = 'info';
        break;
        default:
        $statusDelivery = 'success';
        break;
        }

        switch ($order->confirm) {
        case 'pending':
        $statusConfirm = 'warning';
        break;
        case 'cancel':
        $statusConfirm = 'danger';
        break;
        default:
        $statusConfirm = 'success';
        break;
        }
        @endphp
        <tr>
            <td>
                <div class="form-check form-table-list-check">
                    <input class="form-check-input check-item" value="{{$order->id}}" type="checkbox">
                </div>
            </td>

            <td>
                <span class="text-primary fw-bold"> #{{$order->code}}</span>
            </td>
            <td>
                {{ convertDateTime($order->created_at, 'H:i d/m/Y') }}
            </td>
            <td>
                <div class="mb-1"><b>N: </b>{{$order->fullname}}</div>
                <div class="mb-1"><b>P: </b>{{$order->phone}}</div>
                <div class="mb-1"><b>A: </b>{{$order->address}}</div>
            </td>

            <td>
                {{ array_column(__('payment.method'), 'title', 'name')[$order->payment_method] }}
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
                <span class="badge bg-{{$statusPayment}}">{{__('cart.payment')[$order->payment]}}</span>
            </td>
            <td>
                <span class="badge bg-{{$statusDelivery}}">{{__('cart.delivery')[$order->delivery]}}</span>
            </td>
            <td>
                <span class="badge bg-{{$statusConfirm}}">{{__('cart.confirm')[$order->confirm]}}</span>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

{{-- @include('servers.includes.modalDelete', ['routeModalDelete' => 'order.destroy']) --}}