<!doctype html>
<html class="no-js" lang="en" dir="ltr">



<head>
    {{-- head --}}
    @include('servers.includes.head')

</head>

<body>
    <div id="current-language" data-current-language="{{ app()->getLocale() }}"></div>
    <div id="ebazar-layout" class="theme-blue">

        <!-- sidebar -->
        @include('servers.includes.sidebar')

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            @include('servers.includes.header')
            <!-- Body: Body -->
            @yield('content')

        </div>
        <!-- Modal Custom Settings-->
        @include('servers.includes.customSetting')

    </div>

    {{-- Alert sweetalert --}}
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

    {{-- Script --}}
    @include('servers.includes.script')

    @yield('script')
</body>



</html>