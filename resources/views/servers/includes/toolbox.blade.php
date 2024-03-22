<div class="d-flex justify-content-end gap-2">
    <div class="dropdown">
        <button type="button" role="button" data-bs-toggle="dropdown" class="btn btn-primary position-relative "><i
                class="icofont-tools fs-5"></i></button>

        <div style="inset: 25px 0px auto auto !important;"
            class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-5">
            <div class="card border-0">
                <ul class="list-unstyled py-2 px-3">
                    <li>
                        <a href="#" class="change-status-all" data-model="{{$model}}" data-value="1"
                            data-field="publish">{{__('messages.publishAll')}} </a>
                    </li>
                    <li>
                        <a href="#" class="change-status-all" data-model="{{$model}}" data-value="0"
                            data-field="publish">{{__('messages.unpublishAll')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-primary"><i class="icofont-filter"></i></button>
    </div>
    <div>
        <button class="btn btn-primary"><i class="icofont-filter"></i></button>
    </div>
</div>