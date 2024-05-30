<div class="order-payment-method">
    @foreach (__('payment.method') as $key => $method)
    <div class="single-payment">
        <div class="input-group justify-content-between align-items-center">
            <input type="radio" id="{{$method['name']}}" name="method" value="{{ $method['name'] }}" {{ $key==0
                ? 'checked' : '' }}>
            <label for="{{$method['name']}}">{{ $method['title'] }}</label>
            <img src="{{ $method['image'] }}" alt="{{ $method['title'] }}">
        </div>
        <p>{{ $method['description'] }}</p>
    </div>
    @endforeach
</div>