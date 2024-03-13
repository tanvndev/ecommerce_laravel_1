<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{$config['seo']['title'] ?? 'ebazar'}}</title>

<link rel="icon" href="assets/servers/images/favicon.html" type="image/x-icon"> <!-- Favicon-->

@yield('style')

@include('servers.includes.style')