<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Cấu hình SEO</h6>
        <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>

        <div class="seo-view">
            <span class="link text-success meta-url">{{ url('/') . '/' . old('canonical', $postCatalogue->canonical ??
                '/duong-dan-cua-ban')}}</span>
            <h5 class="meta-title">{{old('meta_title', $postCatalogue->meta_title ?? 'Bạn chưa nhập tiêu đề')}}</h5>
            <p class="meta-description" class="mb-0 ">{{old('meta_description', $postCatalogue->meta_description ?? 'Bạn
                chưa nhập mô tả') }}</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                <label class="form-label">Tiêu đề SEO </label>
                <input type="text" name="meta_title" value="{{old('meta_title', $postCatalogue->meta_title ?? '')}}"
                    class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">Từ khoá SEO </label>
                <input type="text" name="meta_keyword"
                    value="{{old('meta_keyword', $postCatalogue->meta_keyword ?? '')}}" class="form-control">

            </div>

            <div class="col-md-12">
                <label class="form-label">Mô tả SEO</label>
                <textarea name="meta_description" class="form-control" cols="30"
                    rows="10">{{old('meta_description', $postCatalogue->meta_description ?? '')}}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Đường dẫn <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-text">{{url('/')}}/</span>
                    <input type="text" class="form-control" name="canonical"
                        value="{{old('canonical', $postCatalogue->canonical ?? '')}}" autocomplete="">
                </div>
            </div>

        </div>
    </div>
</div>