<div class="col-lg-4">
    <div class="sticky-lg-top">
        <div class="card mb-3 card-create">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Liên kết tự tạo</h6>
                <div class="mt-2 ">
                    <p class="fs-14">Cài đặt menu mà bạn muốn hiển thị</p>
                    <ul type="circle" class="text-danger">
                        <li class="mb-1">Khi khởi tạo menu bạn chắc chắn rằng đường dẫn của menu có hoạt động. Đường dẫn
                            trên website
                            được khởi tạo tại các module: Bài viết, sản phẩm, ...</li>
                        <li class="mb-1">Tiêu đề và đường dẫn của menu không được bỏ trống.</li>
                        <li class="mb-1">Hệ thống chỉ hỗ trợ tối đa 5 cấp menu.</li>
                    </ul>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-info border-style-dashed create-menu-row">
                            Thêm đường dẫn
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion accordion-flush" id="accordionFlush">
                @foreach (__('module.model') as $key => $model)
                <div class="accordion-item menu-list-wrap">
                    <h2 class="accordion-header">
                        <button class="accordion-button button-menu-{{$key}} collapsed menu-module"
                            data-model="{{$key}}" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-{{$key}}">
                            {{ $model }}
                        </button>
                    </h2>
                    <div id="flush-{{$key}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlush"
                        data-model="{{$key}}">
                        <div class="accordion-body">
                            {!! Form::text('name', null, ['class' => 'form-control search-menu',
                            'placeholder' => 'Nhập 2 ký tự để tìm kiếm', 'autocomplete' => 'off']) !!}

                            <div class="menu-list-inner mt-3 "></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>


    </div>

</div>