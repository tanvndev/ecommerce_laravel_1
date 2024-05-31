<div class="order-payment-method">
    @foreach (__('payment.method') as $key => $method)
    @php
    $checked = old('method', $key == 0 ? $method['name'] : '') == $method['name'] ? 'checked' : '';
    @endphp
    <div class="single-payment">
        <div class="input-group justify-content-between align-items-center">
            <input type="radio" id="{{$method['name']}}" name="payment_method" value="{{ $method['name'] }}" {{ $checked
                }}>
            <label for="{{$method['name']}}">{{ $method['title'] }}</label>
            <img src="{{ $method['image'] }}" alt="{{ $method['title'] }}">
        </div>
        <p>{{ $method['description'] }}</p>
    </div>
    @endforeach
</div>