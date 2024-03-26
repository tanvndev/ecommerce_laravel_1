<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                <label class="form-label">{{__('messages.name')}} <span class="text-danger">(*)</span></label>
                <input type="text" name="translate_name" value="{{old('translate_name', $model->name ?? '')}}"
                    class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{__('messages.description')}} </label>
                <textarea name="translate_description" id="ckDescription_2" data-height="200"
                    class="form-control init-ckeditor" cols="30"
                    rows="5">{{old('translate_description', $model->description ?? '')}}</textarea>
            </div>

            <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center justify-content-between ">
                    <label class="form-label">{{__('messages.content')}} </label>
                    <a href="" class="form-label link-primary   mutipleUploadImageCkEditor"
                        data-target="ckContent_2">{{__('messages.uploadMultipleImage')}}</a>
                </div>
                <textarea name="translate_content" id="ckContent_2" data-height="500" class="form-control init-ckeditor"
                    cols="30" rows="5">{{old('translate_content', $model->content ?? '')}}</textarea>
            </div>

        </div>
    </div>
</div>