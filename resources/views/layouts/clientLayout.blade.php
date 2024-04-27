<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    {{-- head --}}
    @include('clients.includes.head')

</head>

<body class="sticky-header newsletter-popup-modal">
    <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
    <div id="current-language" data-current-language="{{ app()->getLocale() }}"></div>

    {{-- Header --}}
    @include('clients.includes.header')

    <main class="main-wrapper">
        <!-- Body: Body -->
        @yield('content')
    </main>
    {{-- Footer --}}
    @include('clients.includes.footer')

    {{-- Modal Search --}}
    @include('clients.includes.modalSearch')

    {{-- Modal Cart --}}
    @include('clients.includes.modalCart')

    <div class="closeMask"></div>

    {{-- Alert sweetalert --}}
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

    {{-- Script --}}
    @include('clients.includes.script')
</body>

</html>