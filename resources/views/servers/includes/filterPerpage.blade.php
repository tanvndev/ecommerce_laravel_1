<div class="col-lg-2">
    <select class="form-select filter" name="perpage" id="">
        @for ($i = 20; $i <= 200; $i+=20) <option {{ request('perpage')==$i ? 'selected' : '' }} value="{{$i}}">
            {{$i}} {{__('messages.perpage')}}</option>
            @endfor

    </select>
</div>