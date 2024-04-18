<div class="col-lg-3">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.basic')}}</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-12">
                        {!! Form::label('name', __('messages.widget.table.name') , ['class' => 'form-label']) !!}
                        <span class="text-danger">(*)</span>
                        {!! Form::text('name', old('name', $widget->name ?? ''), ['class' => 'form-control'])
                        !!}
                    </div>

                    <div class="col-md-12">
                        {!! Form::label('keyword', __('messages.keyword') , ['class' => 'form-label'])
                        !!} <span class="text-danger">(*)</span>
                        {!! Form::text('keyword', old('keyword', $widget->keyword ?? ''), ['class' =>
                        'form-control convert-to-slug']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Shortcode</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        {{ Form::label('short_code', 'Shortcode', ['class' => 'form-label']) }}
                        {{ Form::textarea('short_code', old('short_code', $widget->short_code ?? ''), ['class' =>
                        'form-control textarea-expand',
                        'id' => 'short_code',
                        'rows' => 3]) }}
                    </div>

                </div>


            </div>


        </div>

    </div>
</div>