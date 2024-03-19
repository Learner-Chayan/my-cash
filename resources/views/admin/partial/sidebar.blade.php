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
{{--                <li class="nav-item">--}}
{{--                    <a href="#" class="nav-link {{Request::is('admin') ? 'active' : ''}}">--}}
{{--                        <i class="nav-icon fas fa-dollar-sign"></i>--}}
{{--                        <p>--}}
{{--                            Asset--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item {{Request::is('admin/get-basic') || Request::is('admin/get-about') || Request::is('admin/get-terms') || Request::is('admin/get-privacy') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/get-basic') || Request::is('admin/get-about') || Request::is('admin/get-terms') || Request::is('admin/get-privacy') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cogs"></i><p>Website Setting<i class="fas fa-angle-left right"></i></p>
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
