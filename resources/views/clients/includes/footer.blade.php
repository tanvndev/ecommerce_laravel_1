<div class="service-area">
    <div class="container">
        <div class="row row-cols-xl-4 row-cols-sm-2 row-cols-1 row--20">
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{asset('assets/clients/images/icons/service1.png')}}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Giao hàng nhanh chóng</h6>
                        <p>Hãy kể về dịch vụ của bạn.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{asset('assets/clients/images/icons/service2.png')}}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Đảm bảo lại tiền</h6>
                        <p>Trong vòng 10 ngày.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{asset('assets/clients/images/icons/service3.png')}}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Chính sách hoàn trả 24 giờ</h6>
                        <p>Không có câu hỏi hỏi.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{asset('assets/clients/images/icons/service4.png')}}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Hỗ trợ chuyên nghiệp</h6>
                        <p>Hỗ trợ trực tiếp 24/7.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="axil-footer-area footer-style-2">
    <!-- Start Footer Top Area  -->
    <div class="footer-top separator-top">
        <div class="container">
            <div class="row">
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Support</h5>
                        <div class="logo mb--30">
                            <a href="index.html">
                                <img class="light-logo" src="{{$systemSetting['homepage_logo']}}" alt="Logo Images">
                            </a>
                        </div>
                        <div class="inner">
                            <p>{{$systemSetting['contactpage_address']}}</p>
                            <ul class="support-list-item">
                                <li>
                                    <a href="mailto:{{$systemSetting['contactpage_email']}}"><i
                                            class="fal fa-envelope-open"></i>
                                        {{$systemSetting['contactpage_email']}}</a>
                                </li>
                                <li>
                                    <a href="tel:{{$systemSetting['contactpage_hotline']}}"><i
                                            class="fal fa-phone-alt"></i>
                                        {{$systemSetting['contactpage_hotline']}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if (isset($menus['footer-menu']) && count($menus['footer-menu']) > 0)

                @foreach ($menus['footer-menu'] as $menuFooter)
                @php
                $name = $menuFooter['item']->languages->first()->pivot->name;
                @endphp
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">{{$name}}</h5>
                        @if (count($menuFooter['children']) > 0)
                        <div class="inner">
                            <ul>
                                @foreach ($menuFooter['children'] as $menuFooterChild)
                                @php
                                $name = $menuFooterChild['item']->languages->first()->pivot->name;
                                $canonical = write_url($menuFooterChild['item']->languages->first()->pivot->canonical);
                                @endphp
                                <li>
                                    <a href="{{$canonical}}" title="{{$name}}">{{$name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @endif
                    </div>
                </div>
                @endforeach
                @endif

                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Tải xuống</h5>
                        <div class="inner">
                            <span>Tải xuống ứng dụng của chúng tôi</span>
                            <div class="download-btn-group">
                                <div class="qr-code">
                                    <img src="{{$systemSetting['homepage_qrapp']}}" alt="Axilthemes">
                                </div>
                                <div class="app-link">
                                    <a href="#">
                                        <img src="{{$systemSetting['homepage_appstoreapp']}}" alt="App Store">
                                    </a>
                                    <a href="#">
                                        <img src="{{$systemSetting['homepage_playstoreapp']}}" alt="Play Store">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Widget  -->
            </div>
        </div>
    </div>
    <!-- End Footer Top Area  -->
    <!-- Start Copyright Area  -->
    <div class="copyright-area copyright-default separator-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4">
                    @php
                    $socials = ['fab fa-facebook-f', 'fab fa-instagram', 'fab fa-twitter', 'fab fa-linkedin-in',
                    'fab fa-discord'];
                    @endphp
                    <div class="social-share">
                        @foreach ($socials as $social)
                        <a href="#"><i class="{!!$social!!}"></i></a>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="copyright-left d-flex flex-wrap justify-content-center">
                        <ul class="quick-link">
                            <li>© {{date('Y')}}. Mọi quyền được bảo lưu bởi <a target="_blank"
                                    href="#">{{$systemSetting['homepage_company']}}</a>.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div
                        class="copyright-right d-flex flex-wrap justify-content-xl-end justify-content-center align-items-center">
                        <span class="card-text">Chấp nhận cho</span>
                        <ul class="payment-icons-bottom quick-link">
                            <li><img src="{{$systemSetting['homepage_method_payment']}}" alt="paypal cart"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copyright Area  -->
</footer>