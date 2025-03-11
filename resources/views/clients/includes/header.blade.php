<header class="header axil-header header-style-1">
    <div class="header-top-campaign">
        <div class="container position-relative">
            <div class="campaign-content">
                <p>Open Doors To A World Of Fashion <a href="#">Discover More</a></p>
            </div>
        </div>
        <button class="remove-campaign"><i class="fal fa-times"></i></button>
    </div>

    <div class="axil-header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="header-top-dropdown">
                        @if (empty(!$languages))
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @foreach ($languages as $language)
                                @if ($language->current == 1)
                                {{$language->name}}
                                @endif
                                @endforeach
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($languages as $language)
                                @if ($language->current != 1)
                                <li>
                                    <a title="{{$language->name}}" class="dropdown-item"
                                        href="#">{{$language->name}}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>

                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="header-top-link">
                        <ul class="quick-link">
                            <li><a href="#">Help</a></li>
                            @auth
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ Auth::user()->fullname }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Tài khoản của tôi</a></li>
                                    <li><a class="dropdown-item" href="#">Đơn hàng</a></li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="copyReferralLink(event, '{{ route('auth.register.index', ['ref' => Auth::user()->referral_code]) }}')">
                                            Mã giới thiệu
                                            <span class="copy-status"
                                                style="display: none; font-size: 0.8em; color: green;"> (Đã copy)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a href="{{ route('auth.logout') }}" class="dropdown-item">Đăng xuất</a>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li><a href="{{ route('auth.login.index') }}">Join Us</a></li>
                            <li><a href="{{ route('auth.login.index') }}">Đăng nhập</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('clients.includes.navbar')
</header>
<script>
    function copyToClipboard(button) {
        const input = button.parentElement.previousElementSibling;
        input.select();
        document.execCommand('copy');
        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = 'Copy';
        }, 2000);
    }

    function copyReferralLink(event, referralLink) {
        event.preventDefault();

        // Tạo một input tạm thời
        const tempInput = document.createElement('input');
        tempInput.value = referralLink;
        document.body.appendChild(tempInput);

        // Copy text
        tempInput.select();
        document.execCommand('copy');

        // Xóa input tạm thời
        document.body.removeChild(tempInput);

        // Hiển thị thông báo
        const statusSpan = event.target.querySelector('.copy-status');
        statusSpan.style.display = 'inline';

        // Ẩn thông báo sau 2 giây
        setTimeout(() => {
            statusSpan.style.display = 'none';
        }, 2000);
    }
</script>
