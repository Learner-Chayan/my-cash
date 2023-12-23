<header class="main-header">
    <!-- Logo -->
    <a href="{{route('dashboard')}}" class="logo">
        <span class="logo-mini"><img src="{{asset('public/logo.png')}}"  class="img-circle img-responsive" alt="Logo"></span>
        <span class="logo-lg">{{$site_title}}</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                {{--<li class="">--}}
                    {{--<a target="_blank" href="{{route('frontend')}}">--}}
                        {{--<i class="fa fa-eye" title="View Website"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}

                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{$basic->symbol}} @if($basic->balance < 0 ) <span  class="text-bold"> {{ $basic->balance}}</span> @else{{ $basic->balance}} @endif
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->image != null)
                            <img src="{{ asset('public/images/user') }}/{{ Auth::user()->image }}" class="user-image" alt="User Image">
                        @else
                            <img src="{{ asset('public/default.png') }}" class="user-image" alt="User Image">
                        @endif
                        <span class="hidden-xs">{{ucfirst(Auth::user()->name)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header text-uppercase text-bold">
                            @if(Auth::user()->image != null)
                                <img src="{{asset('public/images/user')}}/{{Auth::user()->image}}" class="img-circle" alt="User Image">
                            @else
                                <img src="{{ asset('public/default.png') }}" class="img-circle" alt="User Image">
                            @endif
                            <p>{{ucfirst(Auth::user()->name)}}-{{ Auth::user()->roles()->pluck('name')->implode(' , ') }}<small>Member Since {{\Carbon\Carbon::parse(Auth::user()->created_at)->format('M.Y')}}</small></p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-12 text-center text-uppercase text-bold">
                                    <a href="{{route('password')}}">Change Password</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left text-uppercase text-bold">
                                <a href="{{route('edit-profile')}}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right text-uppercase text-bold">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();  document.getElementById('logout-form').submit();"> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
            </ul>
        </div>
    </nav>
</header>