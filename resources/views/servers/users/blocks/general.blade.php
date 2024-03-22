<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <label class="form-label">{{__('messages.email')}} <span class="text-danger">(*)</span></label>
                <input type="email" name="email" value="{{old('email', $user->email ?? '')}}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('messages.fullname')}} <span class="text-danger">(*)</span></label>
                <input type="text" name="fullname" value="{{old('fullname', $user->fullname ?? '')}}"
                    class="form-control">
            </div>
            @php
            $catalogues = [
            'Quản trị viên',
            'Cộng tác viên'
            ]
            @endphp
            <div class="col-md-6">
                <label class="form-label">{{__('messages.user.table.userGroup')}} <span
                        class="text-danger">(*)</span></label>
                <select class="form-select init-select2" name="user_catalogue_id">
                    <option disabled selected>[{{__('messages.user.table.userGroupSelect')}}]</option>
                    @empty(!$catalogues)
                    @foreach ($catalogues as $key => $catalogue)
                    @php
                    $key = $key+1;
                    $selected = $key == old('user_catalogue_id', isset($user->user_catalogue_id) ?
                    $user->user_catalogue_id : '') ? 'selected' : ''
                    @endphp
                    <option {{ $selected }} value="{{$key}}">{{$catalogue}}</option>

                    @endforeach
                    @endempty

                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('messages.birthday')}}</label>
                <input type="date" name="birthday" value="{{old('birthday', $user->birthday ?? '')}}"
                    class="form-control">
            </div>
            @if (request()->routeIs('user.create'))
            <div class="col-md-6">
                <label class="form-label">{{__('messages.password')}} <span class="text-danger">(*)</span></label>
                <input type="password" name="password" value="" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('messages.rePassword')}} <span class="text-danger">(*)</span></label>
                <input type="password" name="re_password" value="" class="form-control">
            </div>

            @endif
            <div class="col-md-12">
                <label class="form-label">{{__('messages.image')}}</label>
                <input readonly type="text" data-type="Images" name="image" value="" class="form-control upload-image">
            </div>


        </div>
    </div>
</div>