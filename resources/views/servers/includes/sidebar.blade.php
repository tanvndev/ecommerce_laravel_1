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

            <li><a class="m-link active" href="{{ route('dashboard.index') }}"><i class="icofont-home fs-5"></i>
                    <span>Bảng điều khiển</span></a></li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-product" href="#">
                    <i class="icofont-truck-loaded fs-5"></i> <span>Products</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-product">
                    <li><a class="ms-link " href="product-grid.html">Product Grid</a></li>
                    <li><a class="ms-link " href="product-list.html">Product List</a></li>
                    <li><a class="ms-link " href="product-edit.html">Product Edit</a></li>
                    <li><a class="ms-link " href="product-detail.html">Product Details</a></li>
                    <li><a class="ms-link " href="product-add.html">Product Add</a></li>
                    <li><a class="ms-link " href="product-cart.html">Shopping Cart</a></li>
                    <li><a class="ms-link " href="checkout.html">Checkout</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#categories" href="#">
                    <i class="icofont-chart-flow fs-5"></i> <span>Categories</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="categories">
                    <li><a class="ms-link " href="categories-list.html">Categories List</a></li>
                    <li><a class="ms-link " href="categories-edit.html">Categories Edit</a></li>
                    <li><a class="ms-link " href="categories-add.html">Categories Add</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-order" href="#">
                    <i class="icofont-notepad fs-5"></i> <span>Orders</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-order">
                    <li><a class="ms-link " href="order-list.html">Orders List</a></li>
                    <li><a class="ms-link " href="order-details.html">Order Details</a></li>
                    <li><a class="ms-link " href="order-invoices.html">Order Invoices</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#customers-info" href="#">
                    <i class="icofont-funky-man fs-5"></i> <span>Customers</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="customers-info">
                    <li><a class="ms-link " href="customers.html">Customers List</a></li>
                    <li><a class="ms-link " href="customer-detail.html">Customers Details</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-sale" href="#">
                    <i class="icofont-sale-discount fs-5"></i> <span>Sales Promotion</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-sale">
                    <li><a class="ms-link " href="coupon-list.html">Coupons List</a></li>
                    <li><a class="ms-link " href="coupon-add.html">Coupons Add</a></li>
                    <li><a class="ms-link " href="coupon-edit.html">Coupons Edit</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-inventory" href="#">
                    <i class="icofont-chart-histogram fs-5"></i> <span>Inventory</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-inventory">
                    <li><a class="ms-link " href="inventory-info.html">Stock List</a></li>
                    <li><a class="ms-link " href="purchase.html">Purchase</a></li>
                    <li><a class="ms-link " href="supplier.html">Supplier</a></li>
                    <li><a class="ms-link " href="returns.html">Returns</a></li>
                    <li><a class="ms-link " href="department.html">Department</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-Componentsone" href="#"><i
                        class="icofont-ui-calculator"></i> <span>Accounts</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-Componentsone">
                    <li><a class="ms-link " href="invoices.html">Invoices </a></li>
                    <li><a class="ms-link " href="expenses.html">Expenses </a></li>
                    <li><a class="ms-link " href="salaryslip.html">Salary Slip </a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#app" href="#">
                    <i class="icofont-code-alt fs-5"></i> <span>App</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="app">
                    <li><a class="ms-link " href="calendar.html">Calandar</a></li>
                    <li><a class="ms-link " href="chat.html"> Chat App</a></li>
                </ul>
            </li>

            <li><a class="m-link " href="store-locator.html"><i class="icofont-focus fs-5"></i> <span>Store
                        Locator</span></a></li>
            <li><a class="m-link " href="stater-page.html"><i class="icofont-code fs-5"></i> <span>Stater
                        Page</span></a></li>


            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#menu-Components" href="#"><i
                        class="icofont-paint"></i> <span>UI Components</span> <span
                        class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="menu-Components">
                    <li><a class="ms-link " href="ui-alerts.html"><span>Alerts</span> </a></li>
                    <li><a class="ms-link " href="ui-badge.html"><span>Badge</span></a></li>
                    <li><a class="ms-link " href="ui-breadcrumb.html"><span>Breadcrumb</span></a></li>
                    <li><a class="ms-link " href="ui-buttons.html"><span>Buttons</span></a></li>
                    <li><a class="ms-link " href="ui-card.html"><span>Card</span></a></li>
                    <li><a class="ms-link " href="ui-carousel.html"><span>Carousel</span></a></li>
                    <li><a class="ms-link " href="ui-collapse.html"><span>Collapse</span></a></li>
                    <li><a class="ms-link " href="ui-dropdowns.html"><span>Dropdowns</span></a></li>
                    <li><a class="ms-link " href="ui-listgroup.html"><span>List group</span></a></li>
                    <li><a class="ms-link " href="ui-modal.html"><span>Modal</span></a></li>
                    <li><a class="ms-link " href="ui-navs.html"><span>Navs</span></a></li>
                    <li><a class="ms-link " href="ui-navbar.html"><span>Navbar</span></a></li>
                    <li><a class="ms-link " href="ui-pagination.html"><span>Pagination</span></a></li>
                    <li><a class="ms-link " href="ui-popovers.html"><span>Popovers</span></a></li>
                    <li><a class="ms-link " href="ui-progress.html"><span>Progress</span></a></li>
                    <li><a class="ms-link " href="ui-scrollspy.html"><span>Scrollspy</span></a></li>
                    <li><a class="ms-link " href="ui-spinners.html"><span>Spinners</span></a></li>
                    <li><a class="ms-link " href="ui-toasts.html"><span>Toasts</span></a></li>
                    <li><a class="ms-link " href="ui-tooltips.html"><span>Tooltips</span></a></li>
                </ul>
            </li>


            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#Authentication" href="#">
                    <i class="icofont-ui-lock fs-5"></i> <span>Authentication</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="Authentication">
                    <li><a class="ms-link " href="auth-signin.html">Sign in</a></li>
                    <li><a class="ms-link " href="auth-signup.html">Sign up</a></li>
                    <li><a class="ms-link " href="auth-password-reset.html">Password reset</a></li>
                    <li><a class="ms-link " href="auth-two-step.html">2-Step Authentication</a></li>
                    <li><a class="ms-link " href="auth-404.html">404</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link " data-bs-toggle="collapse" data-bs-target="#page" href="#">
                    <i class="icofont-page fs-5"></i> <span>Other Pages</span> <span
                        class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse " id="page">
                    <li><a class="ms-link " href="admin-profile.html">Profile Page</a></li>
                    <li><a class="ms-link " href="purchase-plan.html">Price Plan Example</a></li>
                    <li><a class="ms-link " href="charts.html">Charts Example</a></li>
                    <li><a class="ms-link " href="table.html">Table Example</a></li>
                    <li><a class="ms-link " href="forms.html">Forms Example</a></li>
                    <li><a class="ms-link " href="icon.html">Icons</a></li>
                    <li><a class="ms-link " href="contact.html">Contact Us</a></li>
                    <li><a class="ms-link " href="todo-list.html">Todo List</a></li>
                </ul>
            </li>

            <li><a class="m-link " href="documentation.html"><i class="icofont-law-document fs-5"></i>
                    <span>Documentation</span></a></li>
            <li><a class="m-link " href="changelog.html"><i class="icofont-edit fs-5"></i>
                    <span>Changelog</span> <span class="ms-auto small-14 fw-bold">v1.0.0</span></a></li>

        </ul>

        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right"></i></span>
        </button>
    </div>
</div>