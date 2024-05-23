<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="robots" content="index, follow">
<meta name="title" content="{{ $seo['meta_title'] ?? '' }}">
<meta name="description" content="{{ $seo['meta_description'] ?? '' }}">
<meta name="keywords" content="{{ $seo['meta_keywords'] ?? '' }}">
<meta name="author" content="{{$systemSetting['homepage_company']}}">
<meta name="copyright" content="{{$systemSetting['homepage_copyright']}}">
<meta name="icon" href="{{$systemSetting['homepage_logo']}}">
<link rel="canonical" href="{{$seo['canonical']}}">
<meta property="og:locale" content="vn_VN">
<meta property="og:type" content="website">
<meta property="og:title" content="{{$seo['meta_title'] ?? 'ecommerce' }}">
<meta property="og:description" content="{{$seo['meta_description'] ?? ''}}">
<meta property="og:url" content="{{$seo['canonical']}}">
<meta property="og:site_name" content="{{$systemSetting['homepage_company']}}">
<meta property="og:image" content="{{$seo['meta_image'] ?? ''}}">
<meta property="og:image:secure_url" content="{{$seo['meta_image'] ?? ''}}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{$seo['meta_title'] ?? 'ecommerce' }}">
<meta name="twitter:description" content="{{$seo['meta_description'] ?? ''}}">
<meta name="twitter:image" content="{{$seo['meta_image'] ?? ''}}">


<title>{{$seo['meta_title'] ?? 'ecommerce'}}</title>

<link rel="icon" href="{{$systemSetting['seo_favicon']}}" type="image/x-icon"> <!-- Favicon-->

<script>
    var BASE_URL = "{{ url('/') }}";
</script>


@include('clients.includes.style')