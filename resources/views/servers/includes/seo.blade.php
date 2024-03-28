<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.seo')['info']}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>

        <div class="seo-view">
            <span class="link text-success meta-url">{{ url('/') . '/' . old('canonical', $model->canonical ??
                __('messages.seoExample')[0])}}</span>
            <h5 class="meta-title">{{old('meta_title', $model->meta_title ?? __('messages.seoExample')[1])}}
            </h5>
            <p class="meta-description" class="mb-0">{{old('meta_description', $model->meta_description ??
                __('messages.seoExample')[2]) }}</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                <label class="form-label">{{__('messages.seo')['title']}} </label>
                <input type="text" name="meta_title" {{isset($disabled) ? 'disabled' : '' }}
                    value="{{old('meta_title', $model->meta_title ?? '')}}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{__('messages.seo')['keyword']}} </label>
                <input type="text" name="meta_keyword" {{isset($disabled) ? 'disabled' : '' }}
                    value="{{old('meta_keyword', $model->meta_keyword ?? '')}}" class="form-control">

            </div>

            <div class="col-md-12">
                <label class="form-label">{{__('messages.seo')['description']}}</label>
                <textarea name="meta_description" {{isset($disabled) ? 'disabled' : '' }} class="form-control" cols="30"
                    rows="10">{{old('meta_description', $model->meta_description ?? '')}}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">{{__('messages.seo')['canonical']}} <span
                        class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-text">{{url('/')}}/</span>
                    <input type="text" class="form-control" {{isset($disabled) ? 'disabled' : '' }} name="canonical"
                        value="{{old('canonical', $model->canonical ?? '')}}" autocomplete="">
                </div>
            </div>

        </div>
    </div>
</div>