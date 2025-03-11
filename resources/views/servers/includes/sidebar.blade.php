<div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">
        <a href="home.html" class="mb-0 brand-icon">
            <span class="logo-icon">
                <i class="bi bi-bag-check-fill fs-4"></i>
            </span>
            <span class="logo-text">eBazar</span>
        </a>
        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1 mt-3">

            @foreach (__('sidebar.module') as $menuItem)
            @php
            $hasSubMenu = isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0;
            $isActive = request()->routeIs($menuItem['activeCondition']);
            @endphp

            <li class="collapsed">
                @if ($hasSubMenu)
                <a class="m-link {{ $isActive ? 'active' : ''}}" data-bs-toggle="collapse"
                    data-bs-target="#menu-{{ $menuItem['id'] }}" href="#">
                    <i class="{{ $menuItem['icon'] }} fs-5"></i>
                    <span>{{ $menuItem['title'] }}</span>
                    <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                @else
                <a class="m-link {{ $isActive ? 'active' : ''}}" href="{{ route($menuItem['route']) }}">
                    <i class="{{ $menuItem['icon'] }} fs-5"></i>
                    <span>{{ $menuItem['title'] }}</span>
                </a>
                @endif

                <!-- Menu: Sub menu ul -->
                @if ($hasSubMenu)
                <ul class="sub-menu collapse {{ $isActive ? 'show' : ''}}" id="menu-{{ $menuItem['id'] }}">
                    @foreach ($menuItem['subMenu'] as $subMenu)
                    <li><a class="ms-link {{ request()->routeIs($subMenu['activeCondition']) ? 'active' : ''}}"
                            href="{{ route($subMenu['route']) }}">{{ $subMenu['title'] }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
            <li>
                <a class="m-link " href="{{ route('mlm.descendants',
                 ['userId' => auth()->id()]) }}">
                    <i class="icofont-handshake-deal fs-5"></i>
                    <span>Danh sách hoa hồng</span>
                </a>
            </li>
        </ul>

        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right"></i></span>
        </button>
    </div>
</div>
