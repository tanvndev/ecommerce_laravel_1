<!-- Modal -->
<div class="modal fade modal-custom-create" id="addNewMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        {!! Form::open(['method' => 'post', 'class' => 'create-menu-catalogue']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  fw-bold">Thêm mới vị trí hiển thị của menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="deadline-form">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            {!! Form::label('name', 'Tên vị trí hiển thị', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            <div class="invalid-feedback name"></div>
                        </div>
                        <div class="col-sm-12">
                            {!! Form::label('keyword', 'Từ khoá', ['class' => 'form-label']) !!}
                            {!! Form::text('keyword', null, ['class' => 'form-control convert-to-slug']) !!}
                            <div class="invalid-feedback keyword"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 "
                    data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
                <button type="submit"
                    class="btn btn-success text-white px-4 py-2 ">{{__('messages.saveButton')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>