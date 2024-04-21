<!-- Modal -->
<div class="modal fade modal-custom-create " id="find-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  fw-bold">Chọn sản phẩm có sẵn hoặc tìm kiếm.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="deadline-form">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <div class="search-product-wrap mt-0 ">
                                <input type="text" class="form-control input-product-search"
                                    placeholder="Tìm kiếm ở đây...">
                                <i class="icofont-search icon-search"></i>

                                <div class="search-product-result card">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 "
                    data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
                <button type="button"
                    class="btn btn-success text-white px-4 py-2 confirm-product-promotion">{{__('messages.saveButton')}}</button>
            </div>
        </div>
    </div>
</div>