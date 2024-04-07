<div class="col-lg-3">
    <div class="d-flex ">
        <div class="w-75">
            {!! Form::text('keyword', request('keyword') ?: old('keyword'), ['class' => 'form-control',
            'placeholder' => __('messages.keywordPlaceholder').'...']) !!}
        </div>
        <div class="ms-2 w-25">
            {!! Form::button('<i class="icofont-filter"></i>', ['type' => 'submit', 'class' => 'btn btn-success
            w-100 text-white']) !!}
        </div>
    </div>
</div>