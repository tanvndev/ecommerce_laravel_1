<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Signup</title>
    <link rel="icon" href="assets/servers/images/favicon.html" type="image/x-icon">
    <!-- project css file  -->
    <link rel="stylesheet" href="assets/servers/css/ebazar.style.min.css">

</head>

<body>

    <div id="ebazar-layout" class="theme-blue">

        <!-- main body area -->
        <div class="main p-2 py-3 p-xl-5 ">

            <!-- Body: Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-xxl">

                    <div class="row g-0">
                        <div
                            class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                            <div style="max-width: 25rem;">
                                <div class="text-center mb-5">
                                    <i class="bi bi-bag-check-fill  text-primary" style="font-size: 90px;"></i>
                                </div>
                                <div class="mb-5">
                                    <h2 class="color-900 text-center">A few clicks is all it takes.</h2>
                                </div>
                                <!-- Image block -->
                                <div class="">
                                    <img src="assets/servers/images/login-img.svg" alt="login-img">
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
                                <!-- Form -->
                                <form class="row g-1 p-3 p-md-4" method="POST" action="{{ route('auth.register') }}">
                                    @csrf
                                    <div class="col-12 text-center mb-5">
                                        <h1>Đăng ký</h1>
                                    </div>
                                    <div class="col-12 text-center mb-4">
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Email </label>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                placeholder="name@example.com">
                                            @error('email')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Họ tên </label>
                                            <input type="text" name="fullname" value="{{ old('fullname') }}"
                                                class="form-control form-control-lg {{ $errors->has('fullname') ? 'is-invalid' : '' }}"
                                                placeholder="Họ tên">
                                            @error('fullname')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Mật khẩu
                                                </span>
                                            </div>
                                            <input type="password" name="password" value="{{ old('password') }}"
                                                class="form-control form-control-lg {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                placeholder="***************">
                                            @error('password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Nhập lại mật khẩu
                                                </span>
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}"
                                                class="form-control form-control-lg {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                placeholder="***************">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Mã giới thiệu (không bắt buộc)
                                                </span>
                                            </div>
                                            <input type="text" name="referral_code"
                                                value="{{ old('referral_code', request()->get('ref', '')) }}"
                                                class="form-control form-control-lg {{ $errors->has('referral_code') ? 'is-invalid' : '' }}">
                                            @error('referral_code')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-lg btn-block btn-light lift text-uppercase"
                                            atl="signin">Đăng ký</a>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <span>Bạn đã có tài khoản? <a href="{{ route('auth.login.index') }}"
                                                class="text-secondary">Đăng nhập</a></span>
                                    </div>
                                </form>
                                <!-- End Form -->

                            </div>
                        </div>
                    </div> <!-- End Row -->

                </div>
            </div>

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/servers/bundles/libscripts.bundle.js"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

</body>


</html>
