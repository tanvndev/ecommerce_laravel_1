@yield('style')

@php
$cssFiles = [
'assets/clients/css/vendor/bootstrap.min.css',
'assets/clients/css/vendor/font-awesome.css',
'assets/clients/css/vendor/flaticon/flaticon.css',
'assets/clients/css/vendor/jquery-ui.min.css',
'assets/clients/css/vendor/slick.css',
'assets/clients/css/vendor/slick-theme.css',
'assets/clients/css/vendor/sal.css',
'assets/clients/css/vendor/magnific-popup.css',
'assets/clients/css/vendor/base.css',
'assets/clients/css/style.min.css',
'assets/clients/css/custom.css',
];
@endphp

@foreach ($cssFiles as $cssFile)
<link rel="stylesheet" href="{{ asset($cssFile) }}">
@endforeach