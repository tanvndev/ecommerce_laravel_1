<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                {!! Form::label('email', __('messages.email') , ['class' => 'form-label']) !!}
                <span class="text-danger">(*)</span>
                {!! Form::email('email', old('email', $user->email ?? ''), ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('fullname', __('messages.fullname') , ['class' => 'form-label']) !!}<span
                    class="text-danger">(*)</span>
                {!! Form::text('fullname', old('fullname', $user->fullname ?? ''), ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('user_catalogue_id', __('messages.user.table.userGroup'), ['class' => 'form-label']) !!}
                <span class="text-danger">(*)</span>
                {!! Form::select('user_catalogue_id', ['' => __('messages.user.table.userGroupSelect')] +
                $userCatalogues->pluck('name', 'id')->toArray(),
                old('user_catalogue_id', $user->user_catalogue_id ?? ''), ['class' => 'form-select init-select2']) !!}
            </div>

            <div class="col-md-6">
                {!! Form::label('birthday', __('messages.birthday'), ['class' => 'form-label']) !!}
                {!! Form::input('date', 'birthday', old('birthday', $user->birthday ?? ''), ['class' => 'form-control'])
                !!}
            </div>

            @if (request()->routeIs('user.create'))
            <div class="col-md-6">
                {!! Form::label('password', __('messages.password'), ['class'
                => 'form-label']) !!} <span class="text-danger">(*)</span>

                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('re_password', __('messages.rePassword'),
                ['class' => 'form-label']) !!}<span class="text-danger">(*)</span>
                {!! Form::password('re_password', ['class' => 'form-control']) !!}
            </div>
            @endif
            <div class="col-md-12">
                {!! Form::label('image', __('messages.image'), ['class' => 'form-label']) !!}
                {!! Form::text('image', old('image', $user->image ?? ''), ['readonly', 'data-type' => 'Images', 'class'
                => 'form-control upload-image']) !!}
            </div>



        </div>
    </div>
</div>