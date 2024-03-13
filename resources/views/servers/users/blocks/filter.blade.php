<form action="{{ route('user.index') }}" method="get" class="form-list-filter">

    <div class="row">
        <div class="col-lg-2">
            <select class="form-select filter" name="perpage" id="">
                @for ($i = 20; $i <= 200; $i+=20) <option {{ request('perpage')==$i ? 'selected' : '' }} value="{{$i}}">
                    {{$i}} bản ghi</option>
                    @endfor

            </select>
        </div>
        <div class="col-lg-7">
            <div class="row">

                <div class="col-lg-4">
                    <select class="form-select filter" name="publish">
                        <option selected value="-1">Chọn tình trạng</option>
                        @foreach (config('apps.general.publish') as $key => $publish)
                        <option {{ request('publish')===$key ? 'selected' : '' }} value="{{ $key }}">{{ $publish }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <select class="form-select" name="user_catalogue_id" id="">
                        <option value="">Chọn nhóm thành viên</option>
                        <option value="">20 bản ghi</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex ">
                <div class="w-75 ">
                    <input type="text" class="form-control" name="keyword"
                        value="{{ request('keyword') ?: old('keyword') }}" placeholder="Tìm kiếm..." />
                </div>
                <div class="ms-2 w-25">
                    <button type="submit" class="btn btn-success w-100 text-white ">
                        <i class="icofont-filter"></i></button>
                </div>
            </div>

        </div>
    </div>
</form>