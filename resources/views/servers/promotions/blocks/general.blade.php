<div class="col-lg-8">
    <div class="card mb-3 card-create">
        <div class="card-header py-3 bg-transparent border-bottom-0">
            <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
            <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                {{__('messages.noteNotice')[1]}}</small>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    {!! Form::label('name', __('messages.promotion.table.name'), ['class' => 'form-label'])
                    !!} <span class="text-danger">(*)</span>
                    {!! Form::text('name', old('name', $promotion->name ?? ''), ['class' => 'form-control'])
                    !!}
                </div>

                <div class="col-md-6">
                    {!! Form::label('code', __('messages.promotion.table.code'), ['class' => 'form-label'])
                    !!}
                    {!! Form::text('code', old('code', $promotion->code ?? ''), ['class' => 'form-control',
                    'placeholder' => 'Nếu không nhập sẽ tự động sinh mã'])!!}
                </div>

                <div class="col-md-12">
                    {!! Form::label('description', __('messages.description'), ['class' => 'form-label'])
                    !!}
                    {!! Form::textarea('description', old('description', $promotion->description ?? ''),
                    ['class' => 'form-control textarea-expand', 'rows' => 3, 'cols' => 30]) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 card-create">
        <div class="card-header py-3 bg-transparent border-bottom-0">
            <h6 class="mb-0 fw-bold ">{{__('messages.infoDetail')}}</h6>
            <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                {{__('messages.noteNotice')[1]}}</small>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-12">
                    {!! Form::label('', __('messages.promotion.table.promotionType'), ['class' =>
                    'form-label mb-3'])!!} <span class="text-danger">(*)</span>

                    {!! Form::select('promotion_method', ['' => __('messages.promotion.table.promotionType')] +
                    __('general.promotion'), old('promotion_method', $promotion->method ?? ''),
                    ['class' => 'form-select init-select2 promotion-method']) !!}

                </div>
                <div class="col-lg-12 promotion-container"></div>
            </div>


            <input type="hidden" class="preload_promotion_method"
                value="{{old('promotion_method', $promotion->method ?? '')}}">

            <input type="hidden" class="preload_select_product_and_quantity"
                value="{{old('module_type', $promotionInfo['model'] ?? '')}}">

            <input type="hidden" class="preload_input_order_amount_range"
                value="{{ json_encode(old('promotion_order_amount_range', $promotionInfo ?? '')) }}">

            <input type="hidden" class="preload_product_and_quantity"
                value="{{ json_encode(old('product_and_quantity', $productAndQuantity ?? '')) }}">

            <input type="hidden" class="preload_object_input"
                value="{{ json_encode(old('object', $promotionInfo['object'] ?? '')) }}">
        </div>
    </div>
</div><!-- Row end  -->