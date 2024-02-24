<!-- Right Icon menu Sidebar -->
<div class="navbar-right">
    <ul class="navbar-nav">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="Notifications" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
            </a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">Notifications</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                <div class="menu-info">
                                    <h4>8 New Members joined</h4>
                                    <p><i class="zmdi zmdi-time"></i> 14 mins ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-amber"><i class="zmdi zmdi-shopping-cart"></i></div>
                                <div class="menu-info">
                                    <h4>4 Sales made</h4>
                                    <p><i class="zmdi zmdi-time"></i> 22 mins ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-red"><i class="zmdi zmdi-delete"></i></div>
                                <div class="menu-info">
                                    <h4><b>Nancy Doe</b> Deleted account</h4>
                                    <p><i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-green"><i class="zmdi zmdi-edit"></i></div>
                                <div class="menu-info">
                                    <h4><b>Nancy</b> Changed name</h4>
                                    <p><i class="zmdi zmdi-time"></i> 2 hours ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-grey"><i class="zmdi zmdi-comment-text"></i></div>
                                <div class="menu-info">
                                    <h4><b>John</b> Commented your post</h4>
                                    <p><i class="zmdi zmdi-time"></i> 4 hours ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-purple"><i class="zmdi zmdi-refresh"></i></div>
                                <div class="menu-info">
                                    <h4><b>John</b> Updated status</h4>
                                    <p><i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-light-blue"><i class="zmdi zmdi-settings"></i></div>
                                <div class="menu-info">
                                    <h4>Settings Updated</h4>
                                    <p><i class="zmdi zmdi-time"></i> Yesterday </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
            </ul>
        </li>
        <li><a href="javascript:void(0);" class="js-right-sidebar" title="Setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="{{ asset('assets/images/logo_small.png')}}" width="35" alt="Zippex"><span class="m-l-10">Zippex</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="{{ asset('assets/images/avatar.png')}}" alt="User"></a>
                    <div class="detail">
                        <h4>{{ auth()->user()->name }}</h4>
                        <small>Super Admin</small>
                    </div>
                </div>
            </li>
            <li class="@if(\Request::is('home'))  active @endif"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            @can(\App\Models\PermissionSet::PERMISSION_PRODUCTS_VIEW)
            <li class="@if(\Request::is('products'))  active @endif"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-collection-item"></i><span>Products</span></a>
                <ul class="ml-menu">
                    @can(\App\Models\PermissionSet::PERMISSION_CATEGORIES_VIEW)
                    <li><a href="{{ route('product.category') }}">Categories</a></li>
                    @endcan
                    <li><a href="{{ route('product') }}">All Products</a></li>
                </ul>
            </li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_ORDERS_VIEW)
            <li class=""><a href="{{ route('order') }}"><i class="zmdi zmdi-mall"></i><span>Orders</span></a></li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_TRANSACTIONS_VIEW)
            <li><a href="javascript:void(0);"><i class="zmdi zmdi-money"></i><span>Transactions</span></a></li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_BLOGS_VIEW)
            <li> <a href="javascript:void(0);"><i class="zmdi zmdi-blogger"></i><span>Blog</span></a></li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_ROLES_VIEW)
            <li class="@if(\Request::is('roles') || \Request::is('roles/*'))  active @endif"> <a href="{{ route('role') }}"><i class="zmdi zmdi-shield-check"></i><span>Roles</span></a></li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_USERS_VIEW)
            <li class="@if(\Request::is('users') || \Request::is('users/*'))  active @endif"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Users</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('user') }}">Customers</a></li>
                    <li><a href="{{ route('user.platform') }}">Platform Users</a></li>
                </ul>
            </li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_FAQS_VIEW)
            <li> <a href="javascript:void(0);"><i class="zmdi zmdi-help-outline"></i><span>FAQ</span></a></li>
            @endcan
            @can(\App\Models\PermissionSet::PERMISSION_TESTIMONIES_VIEW)
            <li> <a href="javascript:void(0);"><i class="zmdi zmdi-comments"></i><span>Testimonies</span></a></li>
            @endcan
        </ul>
    </div>
</aside>