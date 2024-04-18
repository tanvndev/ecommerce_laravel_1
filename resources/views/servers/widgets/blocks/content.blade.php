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
                {!! Form::label('description', __('messages.selectModule'), ['class' => 'form-label']) !!}
                <select class="form-select init-select2" name="module">
                    <option selected value="">{{__('messages.selectModule')}}</option>
                    <option value="Post">Post</option>
                    <option value="PostCatalogue">PostCatalogue</option>
                </select>
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
                        {{-- <div class="search-model-item border-bottom ">
                            <div>
                                <img src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                                    alt="">
                                <span>HINH THUC THANH TOAN DAT HANG ONLINE</span>
                            </div>
                            <button type="button" class="btn-close" aria-label="Close"></button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>