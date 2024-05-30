@if (false)
<div class="axil-checkout-notice">
    <div class="axil-toggle-box">
        <div class="toggle-bar"><i class="fas fa-user"></i> Khách hàng cũ? <a href="javascript:void(0)"
                class="toggle-btn">Nhấp vào đây để đăng nhập <i class="fas fas-angle-down"></i>
            </a>
        </div>
        <div class="axil-checkout-login toggle-open">
            <p>Nếu bạn chưa đăng nhập, vui lòng đăng nhập.</p>
            <div class="signin-box">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group mb--0">
                    <button type="submit" class="axil-btn btn-bg-primary submit-btn">Đăng
                        nhập</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="axil-checkout-billing">
    <h4 class="title mb--40">Chi tiết thanh toán</h4>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                {!! Form::label('fullname', __('messages.fullname')) !!}
                {!! Form::text('fullname', null, ['placeholder' => 'Nhập vào họ và tên', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                {!! Form::label('phone', __('messages.phone')) !!}
                {!! Form::tel('phone', null, ['placeholder' => 'Nhập vào số điện thoại', 'class' => 'form-control']) !!}
            </div>
        </div>

    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', null, ['placeholder' => 'Nhập vào địa chỉ email', 'class' => 'form-control']) !!}
    </div>

    @include('clients.cart.blocks.address')

    <div class="form-group">
        {!! Form::label('description', __('messages.notes')) !!}
        {!! Form::textarea('description', null, ['rows' => 2, 'placeholder' => 'Ghi chú về đơn đặt hàng của bạn, ví dụ:
        ghi chú đặc biệt để giao hàng.', 'class' => 'form-control']) !!}
    </div>

</div>