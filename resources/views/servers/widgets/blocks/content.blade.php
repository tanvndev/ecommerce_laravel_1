<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                {!! Form::label('description', __('messages.description'), ['class' => 'form-label']) !!}
                {!! Form::textarea('description', old('description', $model->description ?? ''), ['id' =>
                'ckDescription', 'class' => 'form-control init-ckeditor', 'cols' => 30, 'rows' => 5, isset($disabled) ?
                'disabled' : '']) !!}
            </div>
        </div>
    </div>
</div>


<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.contentConfiguration')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center widget-search-wrap">
            <div class="col-md-12">
                {!! Form::label('model', __('messages.selectModule'), ['class' => 'form-label']) !!}

                {!! Form::select('model', [__('messages.selectModule')] + __('module.model') , old('model',
                $model->model ?? ''), ['class' =>
                'form-select init-select2'])
                !!}

            </div>

            <div class="col-md-12">
                <div class="search-widget-wrap">
                    <input type="text" class="form-control input-widget-search"
                        placeholder="{{__('messages.searchHere')}}">
                    <i class="icofont-search icon-search"></i>

                    <div class="search-widget-result">
                        {{-- <div class="search-widget-item ">
                            <span class="search-widget-title">
                                HINH THUC THANH TOAN DAT HANG ONLINE
                            </span>
                            <i class="icofont-check"></i>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="search-model-result mt-3 ">
                        @php
                        $moduleItems = old('modelItem', $widgetItem ?? []);
                        @endphp
                        @if (isset($moduleItems) && !empty($moduleItems))
                        @foreach ($moduleItems['id'] as $key => $value)
                        <div class="border-bottom search-model-item" data-modelid="{{$value}}">
                            <div>
                                <img src="{{$moduleItems['image'][$key]}}" alt="{{$moduleItems['name'][$key]}}">
                                <span>{{$moduleItems['name'][$key]}}</span>

                                <input type="hidden" name="modelItem[id][]" value="{{$value}}">
                                <input type="hidden" name="modelItem[name][]" value="{{$moduleItems['name'][$key]}}">
                                <input type="hidden" name="modelItem[image][]" value="{{$moduleItems['image'][$key]}}">
                                <input type="hidden" name="modelItem[canonical][]"
                                    value="{{$moduleItems['canonical'][$key]}}">
                            </div>
                            <button type="button" class="btn-close delete-model-item" aria-label="Close"></button>
                        </div>

                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>