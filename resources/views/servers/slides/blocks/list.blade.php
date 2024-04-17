<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <div class="d-flex justify-content-between align-items-center ">
            <h6 class="mb-0 fw-bold ">{{__('messages.slideList')}}</h6>
            <button type="button" class="btn btn-light shadow-sm add-slide">{{__('messages.addSlide')}}</button>
        </div>
    </div>
    <div class="card-body">
        @php
        $slides = old('slide', $slideItem ?? []) ?? [];
        @endphp
        <div class="list-slide-empty {{empty($slides) ? '' : 'd-none'}}">
            <h6 class="text-center text-muted ">{{__('messages.notSlideYet')}}</h5>
        </div>
        <div class="slide-list sortable">

            @empty(!$slides)
            @foreach ($slides['image'] as $key => $value)
            @php
            $image = $value;
            $description = $slides['description'][$key];
            $canonical = $slides['canonical'][$key];
            $window = $slides['window'][$key] ?? '';
            $name = $slides['name'][$key];
            $alt = $slides['alt'][$key];
            $tab_1 = 'nav-generalInfomation-' . $key;
            $tab_2 = 'nav-seo-' . $key;

            @endphp
            <div class="row g-3 slide-item">
                <div class="col-lg-3 cursor-move">
                    <img class="img-thumbnail img-fluid" src="{{$value}}" alt="{{$value}}">
                    <input type="hidden" name="slide[image][]" value="{{$value}}">
                </div>
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="nav nav-tabs tab-card w-100" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pt-0 active" data-bs-toggle="tab" href="#{{$tab_1}}" role="tab">Thông
                                    tin chung</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pt-0" data-bs-toggle="tab" href="#{{$tab_2}}" role="tab">SEO</a>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-outline-danger fs-12 delete-slide-item mb-1 "><i
                                class="icofont-ui-delete"></i></button>
                    </div>

                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="{{$tab_1}}" role="tabpanel">
                            <div class="row g-3 align-items-center ">
                                <div class="col-lg-12">
                                    {{ Form::label('slide_description', __('messages.description'), ['class' =>
                                    'form-label']) }}
                                    {{ Form::textarea('slide[description][]', $description, ['class' => 'form-control
                                    textarea-expand', 'cols' => 30, 'rows' => 2]) }}

                                </div>
                                <div class="col-lg-9">
                                    {{ Form::text('slide[canonical][]', $canonical, ['class' => 'form-control',
                                    'placeholder' => 'URL']) }}

                                </div>
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        {{-- {{ Form::checkbox('slide[window][]', '_blank', $window != '' ? true :
                                        false,
                                        ['class' => 'form-check-input', 'id' => "slide[window][$key]"]) }}
                                        {{ Form::label("slide[window][$key]", __('messages.openNewTab'), ['class' =>
                                        'form-check-label']) }} --}}

                                        <input class="form-check-input" type="checkbox" {{$window !='' ? 'checked' : ''
                                            }} name="slide[window][]" value="_blank" id="slide[window][{{$key}}]" />
                                        <label class="form-check-label"
                                            for="slide[window][{{$key}}]">{{__('messages.openNewTab')}}</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="{{$tab_2}}" role="tabpanel">
                            <div class="row g-3 align-items-center ">
                                <div class="col-lg-12">
                                    {{ Form::label('slide_name', __('messages.seo.title'), ['class' => 'form-label']) }}
                                    {{ Form::text('slide[name][]', $name, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-lg-12">
                                    {{ Form::label('slide_alt', __('messages.seo.description'), ['class' =>
                                    'form-label']) }}
                                    {{ Form::textarea('slide[alt][]', $alt, ['class' => 'form-control textarea-expand',
                                    'cols' => 30, 'rows' => 2]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endempty
        </div>
    </div>
</div>