@php
$jsFiles = [
'assets/clients/js/vendor/modernizr.min.js',
'assets/clients/js/vendor/jquery.js',
'assets/clients/js/vendor/popper.min.js',
'assets/clients/js/vendor/bootstrap.min.js',
// 'assets/clients/js/vendor/slick.min.js',
'assets/clients/js/vendor/jquery-ui.min.js',
'assets/clients/js/vendor/sal.js',
'assets/clients/js/vendor/jquery.magnific-popup.min.js',
'assets/clients/js/vendor/imagesloaded.pkgd.min.js',
'assets/clients/js/main.js'
// 'assets/clients/js/vendor/isotope.pkgd.min.js',
// 'assets/clients/js/vendor/counterup.js',
// 'assets/clients/js/vendor/waypoints.min.js',
// 'assets/clients/js/vendor/jquery.countdown.min.js',
// 'assets/clients/js/vendor/jquery.style.switcher.js',
// 'assets/clients/js/vendor/js.cookie.js',

];
@endphp

@foreach ($jsFiles as $js)
<script src="{{ asset($js) }}"></script>
@endforeach

@yield('script')