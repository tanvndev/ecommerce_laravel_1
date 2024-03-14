<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Cấu hình SEO</h6>
        <small>Lưu ý: <span class="text-danger">(*)</span> là các trường bắt buộc.</small>

        <div class="seo-view">
            <span class="link">https://example.com.vn</span>
            <h5>Example - Ứng dụng trên Google Play</h5>
            <p class="mb-0 ">Hãy tải ứng dụng Example chính thức dành cho điện thoại và máy tính
                bảng Android. Khám phá nội dung thịnh hành trên thế giới – từ các video nhạc đình
                đám ...</p>
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
                <textarea name="meta_keyword" class="form-control" cols="30" rows="3">
                    {{old('meta_keyword', $postCatalogue->meta_keyword ?? '')}}
                </textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Mô tả SEO</label>
                <textarea name="meta_description" class="form-control" cols="30" rows="10">
                    {{old('meta_description', $postCatalogue->meta_description ?? '')}}
                </textarea>
            </div>

        </div>
    </div>
</div>