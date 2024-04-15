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

{!! Form::open(['method' => 'POST']) !!}
<div class="body d-flex py-3">

    <div class="container-xxl">

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                </div>
            </div>
        </div> <!-- Row end  -->



        <div class="row g-3 mb-3 justify-content-center ">

            @include('servers.includes.messageError')

            <div class="col-lg-4">
                <div class="sticky-lg-top">
                    <div class="mb-3 ms-2 ">
                        @foreach ($languages as $language)
                        @if ($language->current != 1)
                        <a href="{{ route('menu.translate', [$menuCatalogue->id, $language->id])}}">
                            <img class="rounded-2 language-translate-img" src="{{$language->image}}" alt="">
                        </a>
                        @endif
                        @endforeach

                    </div>
                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="m-0 fw-bold">{{$config['seo']['title']}}</h6>
                            <div class="mt-3 ">
                                <ul type="circle" class="">
                                    <li class="mb-1"> Danh sách Menu giúp bạn dễ dàng kiểm soát bố cục menu. Bạn có thể
                                        thêm mới hoặc cập nhập menu bằng nút <span class="text-primary">Cập nhập
                                            menu</span>.</li>
                                    <li class="mb-1">Bạn có thể thay đổi vị trí hiển thị của menu bằng cách di chuyển
                                        menu đến vị trí mong muốn.</li>
                                    <li class="mb-1">Dễ dàng khởi tạo menu con bằng cách ấn vào nút <span
                                            class="text-info">Quản lý menu con</span>.</li>
                                    <li><span class="text-danger ">Hỗ trợ tối đa 5 cấp menu</span>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-3 card-create">
                    <div class="card-header py-3 bg-transparent border-bottom-0">
                        <div class="d-flex justify-content-between align-content-center ">
                            <h6 class="mb-0 fw-bold text-uppercase ">{{$menuCatalogue->name}}</h6>
                            <a class="link-primary" href="{{route('menu.editMenu', request('id'))}}">Cập nhập menu cấp
                                1</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 d-flex align-items-center">
                            <div class="ibox-content mt-0" id="menuCatalogueId"
                                data-catalogue-id="{{request('id') ?? ''}}">
                                @php
                                $menus = recursive($menus ?? []);
                                $menuString = recursive_menu($menus);
                                @endphp
                                @empty(!$menus)
                                <div class="dd" id="nestable2">
                                    <ol class="dd-list">
                                        {!! $menuString !!}
                                    </ol>
                                </div>
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- Row end  -->

    </div>
</div>
{!! Form::close() !!}

@include('servers.menus.blocks.popup')
@endsection