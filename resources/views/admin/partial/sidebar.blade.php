<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @php
        $user  = auth()->user();
        $media = $user->getMedia('user')->first()
    @endphp
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('logo.png')}}" alt="{{$basic->title}}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{$basic->title}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ $media ? $media->getUrl() : asset('public/default.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$user->name}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{Request::is('dashboard') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header text-uppercase">Manage Ads Post</li>
                <li class="nav-item {{Route::currentRouteNamed('ads.index') || Route::currentRouteNamed('ads.create') || Route::currentRouteNamed('ads.edit') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Route::currentRouteNamed('ads.index') || Route::currentRouteNamed('ads.create') || Route::currentRouteNamed('ads.edit') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-blog"></i><p>Ads Post<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('ads.index')}}" class="nav-link {{Route::currentRouteNamed('ads.index') || Route::currentRouteNamed('ads.edit')  ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ads Post List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header text-uppercase">Manage Gift Post</li>
                <li class="nav-item {{Route::currentRouteNamed('gift.index') || Route::currentRouteNamed('gift.create') || Route::currentRouteNamed('gift.edit') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Route::currentRouteNamed('gift.index') || Route::currentRouteNamed('gift.create') || Route::currentRouteNamed('gift.edit') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-gift"></i><p>Gift Post<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('gift.create')}}" class="nav-link {{Route::currentRouteNamed('gift.create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Gift Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('gift.index')}}" class="nav-link {{Route::currentRouteNamed('gift.index') || Route::currentRouteNamed('gift.edit')  ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gift Post List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header text-uppercase">Manage Asset Price</li>
                <li class="nav-item {{Route::currentRouteNamed('asset-price.index') || Route::currentRouteNamed('asset-price.create') || Route::currentRouteNamed('asset-price.edit') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Route::currentRouteNamed('asset-price.index') || Route::currentRouteNamed('asset-price.create') || Route::currentRouteNamed('asset-price.edit') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-clipboard-check"></i><p>Asset Price<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('asset-price.create')}}" class="nav-link {{Route::currentRouteNamed('asset-price.create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Asset Price</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('asset-price.index')}}" class="nav-link {{Route::currentRouteNamed('asset-price.index') || Route::currentRouteNamed('asset-price.edit')  ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Asset Price List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header text-uppercase">Manage Customer</li>
                <li class="nav-item {{Route::currentRouteNamed('request') || Route::currentRouteNamed('verify-request') || Route::currentRouteNamed('customer') || Route::currentRouteNamed('edit') || Route::currentRouteNamed('show') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Route::currentRouteNamed('customer') || Route::currentRouteNamed('show') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-users"></i><p>Customer<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('request')}}" class="nav-link {{Request::is('admin/verification/request') || Route::currentRouteNamed('verify-request') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Verification Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer','regular')}}" class="nav-link {{Request::is('admin/customer/regular') || Route::currentRouteNamed('edit') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regular Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer','agent')}}" class="nav-link {{Request::is('admin/customer/agent') || Route::currentRouteNamed('edit') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agent Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header text-uppercase">Setting</li>
                <li class="nav-item {{Request::is('admin/get-basic') || Request::is('admin/get-about') || Request::is('admin/get-terms') || Request::is('admin/get-privacy') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/get-basic') || Request::is('admin/get-about') || Request::is('admin/get-terms') || Request::is('admin/get-privacy') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cog"></i><p>Website Basic<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{route('get-about')}}" class="nav-link {{Request::is('admin/get-about') ? 'active' : ''}}">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>About</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{route('get-privacy')}}" class="nav-link {{Request::is('admin/get-privacy') ? 'active' : ''}}">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Privacy</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{route('get-terms')}}" class="nav-link {{Request::is('admin/get-terms') ? 'active' : ''}}">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Terms & Condition</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a href="{{route('get-basic')}}" class="nav-link {{Request::is('admin/get-basic') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Basic Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @role('super-admin')
                <li class="nav-item {{Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/permissions') || Request::is('admin/permissions/create') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link  {{Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/permissions') || Request::is('admin/permissions/create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-secret"></i><p>Users & Role<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link {{Request::is('admin/roles') || Request::is('admin/roles/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link {{Request::is('admin/permissions') || Request::is('admin/permissions/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link {{Request::is('admin/users') || Request::is('admin/users/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endrole

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
