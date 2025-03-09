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
                            <li><a href="{{ route('auth.login.index') }}">Join Us</a></li>
                            <li><a href="{{ route('auth.login.index') }}">Sign In</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('clients.includes.navbar')
</header>
