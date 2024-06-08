<div class="col-xl-12 col-xxl-4">
    @php
    $delivery = $order->delivery
    @endphp
    <div class="card mb-3">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
            <h6 class="mb-0 fw-bold ">{{__('messages.order.table.status')}}</h6>
            <span
                class="ms-3 badge bg-{{__('order.delivery')[$delivery]['color']}}">{{__('cart.delivery')[$delivery]}}</span>

        </div>
        <div class="card-body card-create">
            {!! Form::open(['route' => ['order.update', $order->id], 'method' => 'put']) !!}
            <div class="row g-3 align-items-center">
                <div class="col-md-12">
                    <label class="form-label">{{__('messages.code')}}</label>
                    <input type="text" disabled class="form-control" value="#{{$order->code}}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">{{__('messages.status')}}</label>
                    <select name="confirm" id="confirm" class="w-100 init-nice-select">
                        @foreach (__('cart.confirm') as $value => $label)
                        @if ($value == '') @continue @endif
                        <option value="{{ $value }}" {{ old('confirm', $order->confirm ?? '') == $value ? 'selected' :
                            '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">{{ __('messages.delivery') }}</label>

                    <select name="delivery" id="delivery" class="w-100 init-nice-select">
                        @foreach (__('cart.delivery') as $value => $label)
                        @if ($value == '') @continue @endif
                        <option value="{{ $value }}" {{ old('delivery', $order->delivery ?? '') == $value ? 'selected' :
                            '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>


                </div>
                <div class="col-md-12">
                    <label class="form-label">{{ __('messages.payment') }}</label>

                    <select name="payment" id="payment" class="w-100 init-nice-select">
                        @foreach (__('cart.payment') as $value => $label)
                        @if ($value == '') @continue @endif
                        <option value="{{ $value }}" {{ old('payment', $order->payment ?? '') == $value ? 'selected' :
                            '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>


                </div>
            </div>
            <button type="submit"
                class="btn btn-success py-2 w-100 text-white px-4 mt-4 text-uppercase">{{__('messages.updateBtn')}}</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>