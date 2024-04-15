@extends('layouts.serverLayout')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('script')
<script src="{{ asset('assets/servers/plugin/nestable/jquery.nestable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/servers/js/library/menu.js')}}"></script>



@endsection

@section('content')

{!! Form::open(['method' => 'PUT', 'route'=> ['menu.save.translate', request('languageId')], 'files' => true]) !!}
<div class="body d-flex py-3">

    <div class="container-xxl">

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                    <button type="submit"
                        class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">{{__('messages.saveButton')}}
                </div>
            </div>
        </div> <!-- Row end  -->



        <div class="row g-3 mb-3 justify-content-center ">

            @include('servers.includes.messageError')

            <div class="col-lg-4">
                <div class="sticky-lg-top">
                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="m-0 fw-bold">{{$config['seo']['title']}}</h6>
                            <div class="mt-3 ">
                                <ul type="circle" class="">
                                    <li class="mb-1"> Hệ thống tự động lấy ra các bản dịch <span
                                            class="text-primary">Nếu có</span>.</li>
                                    <li class="mb-1">Cập nhập các thôn tin về bản dịch cho các menu phía bên phải.</li>
                                    <li class="mb-1">Lưu ý cập nhập đầy đủ thông tin về bản dịch.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold text-uppercase ">Danh sách bản dịch</h6>

                    </div>
                    <div class="card-body">
                        @if (count($menus))
                        @foreach ( $menus as $menu)
                        @php
                        $name = $menu->languages->first()->pivot->name;
                        $canonical = $menu->languages->first()->pivot->canonical;
                        @endphp
                        <div class="menu-translate-item">
                            <span class="fw-bold mb-2 text-danger ">
                                Menu: {{$menu->position}}
                            </span>
                            <div class="row g-3 d-flex align-items-center mb-2 ">
                                <div class="col-lg-2">
                                    <label class="form-label">Tên menu</label>
                                </div>
                                <div class="col-lg-5">
                                    {!! Form::text('', $name, ['class' => 'form-control', 'disabled' =>
                                    'disabled'])
                                    !!}
                                    {!! Form::hidden('translate[id][]', $menu->id) !!}
                                </div>
                                <div class="col-lg-5">
                                    {!! Form::text('translate[name][]', old('translate[name][]', $menu->translate_name
                                    ?? '' ), ['class' =>
                                    'form-control']) !!}
                                </div>

                            </div>
                            <div class="row g-3 d-flex align-items-center">
                                <div class="col-lg-2">
                                    <label class="form-label">Đường dẫn</label>
                                </div>
                                <div class="col-lg-5">
                                    {!! Form::text('', $canonical, ['class' => 'form-control', 'disabled' =>
                                    'disabled'])
                                    !!}
                                </div>
                                <div class="col-lg-5">
                                    {!! Form::text('translate[canonical][]', old('translate[canonical][]',
                                    $menu->translate_canonical ?? ''), ['class' =>
                                    'form-control'])
                                    !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div><!-- Row end  -->

    </div>
</div>
{!! Form::close() !!}

@include('servers.menus.blocks.popup')
@endsection