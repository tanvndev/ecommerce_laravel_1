<div class="modal fade modal-custom-delete p-3 " id="modal-delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center align-item-center ">
                <div class="pt-4 ">
                    <i class="fs-3  icofont-ui-delete text-danger"></i>
                </div>
            </div>
            <div class="modal-body text-center ">
                <h6 class="fw-bold ">{{__('messages.deleteModalTitle')}}</h6>
                <p class="fs-13 mb-1 mt-3 ">{{__('messages.deleteModalDescription')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 "
                    data-bs-dismiss="modal">{{__('messages.cancelButton')}}</button>
                {!! Form::open(['route' => $routeModalDelete, 'method' => 'delete']) !!}
                {!! Form::hidden('_id', null, ['id' => '_id']) !!}
                {!! Form::button(__('messages.agreeButton'), ['type' => 'submit', 'class' => 'btn btn-success text-white
                px-4 py-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>