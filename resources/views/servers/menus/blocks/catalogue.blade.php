<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Vị trí menu</h6>
        <small>Website có các vị trí hiển thị cho từng menu. Lựa chọn vị trí muốn hiển thị.</small>
    </div>
    <div class="card-body">
        <div class="row g-3 d-flex align-items-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center ">
                    <label id="menu_catalogue_id" class="form-label">Vị trí hiển thị <span
                            class="text-danger">(*)</span></label>

                    <div class="d-grid gap-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addNewMenu"
                            class="btn btn-outline-info ">
                            Tạo vị trí hiển thị
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {!! Form::select('menu_catalogue_id', ['Chọn vị trí hiển thị'] + $menuCatalogues->pluck('name',
                'id')->toArray(), old('menu_catalogue_id', request('id') ?? ''), ['class' => 'form-select
                init-select2
                menu-catalogue-id']) !!}
            </div>

        </div>
    </div>
</div>