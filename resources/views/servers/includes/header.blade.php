<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">

            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center order-1">
                <div class="d-flex">
                    <a class="nav-link text-primary collapsed" href="" title="Get Help">
                        <i class="icofont-info-square fs-5"></i>
                    </a>
                </div>
                <div class="dropdown ms-3">
                    <button class="nav-link dropdown-toggle pulse" type="button" role="button"
                        data-bs-toggle="dropdown">
                        @foreach ($languages as $language)
                        @if ($language->current == 1)
                        <img class="rounded-2 language-item-img" src="{{$language->image}}" alt="">
                        @break
                        @endif
                        @endforeach
                    </button>
                    <div
                        class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-3">
                        <div class="card border-0">
                            <ul class="list-unstyled py-2 px-3 mb-0 ">
                                @foreach ($languages as $language)
                                @if ($language->current != 1)
                                <li class="d-flex align-items-center">
                                    <span class="language-item-img">
                                        <img class="language-item-img" src="{{$language->image}}" alt="">
                                    </span>
                                    <a class="link-body-emphasis"
                                        href="{{route('language.switch', $language->canonical)}}">{{$language->name}}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dropdown  ms-3">
                    <button class="nav-link dropdown-toggle pulse" type="button" role="button"
                        data-bs-toggle="dropdown">
                        <i class="icofont-alarm fs-5"></i>
                    </button>
                    <div id="NotificationsDiv"
                        class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-3">
                        <div class="card border-0 w380">
                            <div class="card-header border-0 p-3">
                                <h5 class="mb-0 font-weight-light d-flex justify-content-between">
                                    <span>Notifications</span>
                                    <span class="badge text-white">06</span>
                                </h5>
                            </div>
                            <div class="tab-content card-body">
                                <div class="tab-pane fade show active">
                                    <ul class="list-unstyled list mb-0">
                                        <li class="py-2 mb-1 border-bottom">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <img class="avatar rounded-circle"
                                                    src="{{asset('assets/servers/images/xs/avatar1.svg')}}" alt="">
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Chloe Walkerr</span>
                                                        <small>2MIN</small>
                                                    </p>
                                                    <span class="">Added New Product 2021-07-15 <span
                                                            class="badge bg-success">Add</span></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="py-2 mb-1 border-bottom">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <div class="avatar rounded-circle no-thumbnail">AH</div>
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Alan Hill</span>
                                                        <small>13MIN</small>
                                                    </p>
                                                    <span class="">Invoice generator </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="py-2 mb-1 border-bottom">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <img class="avatar rounded-circle"
                                                    src="{{asset('assets/servers/images/xs/avatar3.svg')}}" alt="">
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Melanie Oliver</span>
                                                        <small>1HR</small>
                                                    </p>
                                                    <span class="">Orader Return RT-00004</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="py-2 mb-1 border-bottom">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <img class="avatar rounded-circle"
                                                    src="{{asset('assets/servers/images/xs/avatar5.svg')}}" alt="">
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Boris Hart</span>
                                                        <small>13MIN</small>
                                                    </p>
                                                    <span class="">Product Order to Toyseller</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="py-2 mb-1 border-bottom">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <img class="avatar rounded-circle"
                                                    src="{{asset('assets/servers/images/xs/avatar6.svg')}}" alt="">
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Alan Lambert</span>
                                                        <small>1HR</small>
                                                    </p>
                                                    <span class="">Leave Apply</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="py-2">
                                            <a href="javascript:void(0);" class="d-flex">
                                                <img class="avatar rounded-circle"
                                                    src="{{asset('assets/servers/images/xs/avatar7.svg')}}" alt="">
                                                <div class="flex-fill ms-2">
                                                    <p class="d-flex justify-content-between mb-0 "><span
                                                            class="font-weight-bold">Zoe Wright</span>
                                                        <small class="">1DAY</small>
                                                    </p>
                                                    <span class="">Product Stoke Entry Updated</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <a class="card-footer text-center border-top-0" href="#"> View all
                                notifications</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown user-profile ms-3 d-flex align-items-center">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm "><span class="font-weight-bold">John
                                Quinn</span></p>
                        <small>Admin Profile</small>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static">
                        <img class="avatar lg rounded-circle img-thumbnail" src="" alt="profile">
                    </a>
                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                        <div class="card border-0 w280">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    <img class="avatar rounded-circle" src="" alt="profile">
                                    <div class="flex-fill ms-3">
                                        <p class="mb-0"><span class="font-weight-bold">John Quinn</span></p>
                                        <small class="">Johnquinn@gmail.com</small>
                                    </div>
                                </div>

                                <div>
                                    <hr class="dropdown-divider border-dark">
                                </div>
                            </div>
                            <div class="list-group m-2 ">
                                <a href="admin-profile.html" class="list-group-item list-group-item-action border-0 "><i
                                        class="icofont-ui-user fs-5 me-3"></i>Profile Page</a>
                                <a href="order-invoices.html"
                                    class="list-group-item list-group-item-action border-0 "><i
                                        class="icofont-file-text fs-5 me-3"></i>Order Invoices</a>
                                <a href="auth-signin.html" class="list-group-item list-group-item-action border-0 "><i
                                        class="icofont-logout fs-5 me-3"></i>Signout</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="setting ms-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal"><i
                            class="icofont-gear-alt fs-5"></i></a>
                </div>
            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainHeader">
                <span class="fa fa-bars"></span>
            </button>

            <!-- main menu Search-->
            <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                <div class="input-group flex-nowrap input-group-lg">
                    <input type="search" class="form-control" placeholder="Search" aria-label="search"
                        aria-describedby="addon-wrapping">
                    <button type="button" class="input-group-text" id="addon-wrapping"><i
                            class="fa fa-search"></i></button>
                </div>
            </div>

        </div>
    </nav>
</div>