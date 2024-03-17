<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Thông tin chung</h6>
        <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                <label class="form-label">Tên bài viết <span class="text-danger">(*)</span></label>
                <input type="text" name="name" value="{{old('name', $post->name ?? '')}}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">Mô tả ngắn </label>
                <textarea name="description" id="ckDescription" data-height="200" class="form-control init-ckeditor"
                    cols="30" rows="5">
                        {{old('description', $post->description ?? '')}}
                    </textarea>
            </div>

            <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center justify-content-between ">
                    <label class="form-label">Nội dung </label>
                    <a href="" class="form-label link-primary mutipleUploadImageCkEditor" data-target="ckContent">Upload
                        nhiều ảnh </a>
                </div>
                <textarea name="content" id="ckContent" data-height="500" class="form-control init-ckeditor" cols="30"
                    rows="5">
                        {{old('content', $post->content ?? '')}}
                    </textarea>
            </div>

        </div>
    </div>
</div>