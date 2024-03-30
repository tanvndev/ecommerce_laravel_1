<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.parentId')}}</h6>
                <small class="text-danger ">*{{__('messages.parentIdNotice')}}</small>
            </div>
            <div class="card-body">
                <label class="form-label">{{__('messages.parentId')}}</label>
                <select class="form-select init-select2" name="parent_id">
                    @foreach ($dropdown as $key => $val)
                    <option {{ $key==old('parent_id', isset($attributeCatalogue->parent_id) ?
                        $attributeCatalogue->parent_id : '') ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="card mb-3 card-create">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.advance')}}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{__('messages.publish')}}</label>

                    <select class="form-select init-select2" name="publish">
                        @foreach (__('messages.general.publish') as $key => $publish)

                        <option {{ $key==old('publish', isset($attributeCatalogue->publish) ?
                            $attributeCatalogue->publish : '') ? 'selected' : '' }} value="{{$key}}">{{
                            $publish }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{__('messages.follow')}}</label>
                    <select class="form-select init-select2" name="follow">
                        @foreach (__('messages.general.follow') as $key => $follow)
                        <option {{ $key==old('follow', isset($attributeCatalogue->follow) ?
                            $attributeCatalogue->follow : '') ? 'selected' : '' }} value="{{$key}}">{{
                            $follow }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">{{__('messages.image')}}</h6>
            </div>
            <div class="card-body">
                <img class="img-thumbnail h-250 w-100 img-contain img-target" src="{{ (old('image', $attributeCatalogue->image ?? asset('assets/servers/images/others/no-image.png'))) ?? asset('assets/servers/images/others/no-image.png') }}" alt="no-image">
                <input type="hidden" name="image" value="{{old('image', $attributeCatalogue->image ?? '')}}" class="image">
            </div>
        </div>

    </div>
</div>