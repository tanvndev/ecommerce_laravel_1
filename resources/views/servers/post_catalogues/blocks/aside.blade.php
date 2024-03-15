<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Danh mục cha</h6>
                {{-- <small class="text-danger ">*Chọn root nếu không có danh mục cha</small> --}}
            </div>
            <div class="card-body">
                <label class="form-label">Danh mục cha</label>
                <select class="form-select init-select2" name="parent_id">
                    @foreach ($dropdown as $key => $val)
                    <option {{ $key==old('parent_id', isset($postCatalogue->parent_id) ?
                        $postCatalogue->parent_id : '') ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                    @endforeach
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

                        <option {{ $key==old('publish', isset($postCatalogue->publish) ?
                            $postCatalogue->publish : '') ? 'selected' : '' }} value="{{
                            $key }}">{{
                            $publish }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Điều hướng</label>
                    <select class="form-select init-select2" name="follow">
                        <option selected value="-1">Chọn điều hướng</option>
                        @foreach (config('apps.general.follow') as $key => $follow)
                        <option {{ $key==old('follow', isset($postCatalogue->follow) ?
                            $postCatalogue->follow : '') ? 'selected' : '' }} value="{{ $key
                            }}">{{
                            $follow }}
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
                    src="{{ (old('image', $postCatalogue->image ?? asset('assets/servers/images/others/no-image.png'))) ?? asset('assets/servers/images/others/no-image.png') }}"
                    alt="no-image">
                <input type="hidden" name="image" value="{{old('image', $postCatalogue->image ?? '')}}" class="image">
            </div>
        </div>

    </div>
</div>