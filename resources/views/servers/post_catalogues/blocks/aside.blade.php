<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Danh mục cha</h6>
                <small class="text-danger ">*Chọn root nếu không có danh mục cha</small>
            </div>
            <div class="card-body">
                <label class="form-label">Danh mục cha</label>
                <select class="form-select init-select2" name="parent_id">
                    <option selected>Chọn danh mục cha</option>
                    <option value="1">Root</option>
                    <option value="2">...</option>
                </select>

            </div>
        </div>
        <div class="card mb-3 card-create">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Cấu hình nâng cao</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tình trạng</label>

                    <select class="form-select init-select2" name="publish">
                        <option selected value="-1">Chọn tình trạng</option>
                        @foreach (config('apps.general.publish') as $key => $publish)
                        <option {{ request('publish')===$key ? 'selected' : '' }} value="{{ $key }}">{{
                            $publish }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Điều hướng</label>
                    <select class="form-select init-select2" name="publish">
                        <option selected value="-1">Chọn điều hướng</option>
                        @foreach (config('apps.general.follow') as $key => $publish)
                        <option {{ request('publish')===$key ? 'selected' : '' }} value="{{ $key }}">{{
                            $publish }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Ảnh đại diện</h6>
            </div>
            <div class="card-body">
                <img class="img-thumbnail h-250 w-100 img-contain img-target"
                    src="{{asset('assets/servers/images/others/no-image.png')}}" alt="no-image">
                <input type="hidden" name="image" class="image">
            </div>
        </div>
        <div class="card mb-3">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Publish Schedule</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-12">
                        <label class="form-label">Publish Date</label>
                        <input type="date" class="form-control w-100">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Publish Time</label>
                        <input type="time" class="form-control w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div
                class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Categories</h6>
            </div>
            <div class="card-body">
                <label class="form-label">Parent category Select</label>
                <select class="form-select" size="3" aria-label="size 3 select example">
                    <option value="2">Clothes</option>
                    <option value="3">Toy</option>
                    <option value="4">Cosmetic</option>
                    <option value="5">Laptop</option>
                    <option value="6">Mobile</option>
                    <option value="7">Watch</option>
                </select>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Categories Image Upload</h6>
                <small>With event and default file try to remove the image</small>
            </div>
            <div class="card-body">
                <input type="file" id="dropify-event"
                    data-default-file="assets/images/product/cropimg-upload.jpg') !!}">
            </div>
        </div>
    </div>
</div>