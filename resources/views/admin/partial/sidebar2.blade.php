<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                @if(Auth::user()->image !=null)
                    <img src="{{asset('public/images/user')}}/{{Auth::user()->image}}" class="img-circle" alt="User Image">
                @else
                    <img src="{{asset('public/default.png')}}" class="img-circle" alt="User Image">

                @endif
            </div>
            <div class="pull-left info">
                <p>{{ucfirst(Auth::user()->name)}}</p>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> <span class="text-uppercase text-bold">Dashboard</span></a>
            </li>
            @role('admin')
            @if(env('ADVERTISEMENT_STATUS'))
                <li class="treeview
                        {{Request::is('admin/advertisement') ? 'active' : ''}}
                        {{Request::is('admin/advertisement-create') ? 'active' : ''}}
                        {{Request::is('admin/advertisement-edit/{id}') ? 'active' : ''}}
                        ">
                    <a href="#"><i class="fa fa-bookmark-o"></i><span class="text-uppercase text-bold">Manage Advertisement</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li class="{{Request::is('admin/advertisement-create') ? 'active' : ''}}  "><a href="{{route('advertisement-create')}}" class="text-uppercase text-bold"><i class="fa fa-plus"></i> Add Advertisement</a></li>
                        <li class=" {{Request::is('admin/advertisement') ? 'active' : ''}} "><a href="{{route('advertisement')}}" class="text-uppercase text-bold"><i class="fa fa-list"></i> Advertisement</a></li>
                    </ul>
                </li>
            @endif
            <li class="treeview
                        {{Request::is('admin/get-basic') ? 'active' : ''}}
                        {{Request::is('admin/get-copy-right') ? 'active' : ''}}
                        {{Request::is('admin/sliders') ? 'active' : ''}}
                        {{Request::is('admin/sliders/create') ? 'active' : ''}}
                        {{Request::is('admin/socials') ? 'active' : ''}}
                        {{Request::is('admin/socials/create') ? 'active' : ''}}
                        {{Request::is('admin/faqs') ? 'active' : ''}}
                        {{Request::is('admin/faqs/create') ? 'active' : ''}}
                        {{Request::is('admin/get-about') ? 'active' : ''}}
                        {{Request::is('admin/get-terms') ? 'active' : ''}}
                        {{Request::is('admin/get-privacy') ? 'active' : ''}}
                    ">
                <a href="#"><i class="fa fa-cogs"></i><span class="text-uppercase text-bold"> Website Setting</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/get-basic') ? 'active' : ''}}"><a href="{{route('get-basic')}}" class="text-uppercase text-bold"><i class="fa fa-gg"></i>Basic Setting</a></li>
                @if(env('SLIDER_STATUS'))
                        <li class="{{Request::is('admin/sliders') ? 'active' : ''}} {{Request::is('admin/sliders/create') ? 'active' : ''}}"><a href="{{route('sliders.index')}}" class="text-uppercase text-bold"><i class="fa fa-sliders"></i>Manage Slider</a></li>
                    @endif
                    @if(env('SOCIAL_STATUS'))
                        <li class="{{Request::is('admin/socials') ? 'active' : ''}} {{Request::is('admin/socials/create') ? 'active' : ''}}"><a href="{{route('socials.index')}}" class="text-uppercase text-bold"><i class="fa fa-soccer-ball-o"></i>Manage Socials</a></li>
                    @endif
                    @if(env('FAQ_STATUS'))
                        <li class="{{Request::is('admin/faqs') ? 'active' : ''}} {{Request::is('admin/faqs/create') ? 'active' : ''}}"><a href="{{route('faqs.index')}}" class="text-uppercase text-bold"><i class="fa fa-rocket"></i>Manage Faq</a></li>
                    @endif
                    <li class="" style="color: white; margin-left: 13px">Basic Frontend</li>

                    <li class="{{Request::is('admin/get-about') ? 'active' : ''}}"><a href="{{route('get-about')}}" class="text-uppercase text-bold"><i class="fa fa-dot-circle-o"></i>About Update</a></li>
                    <li class="{{Request::is('admin/get-privacy') ? 'active' : ''}}"><a href="{{route('get-privacy')}}" class="text-uppercase text-bold"><i class="fa fa-crosshairs"></i>Privacy Update</a></li>
                    <li class="{{Request::is('admin/get-terms') ? 'active' : ''}}"><a href="{{route('get-terms')}}" class="text-uppercase text-bold"><i class="fa fa-terminal"></i>Terms Update</a></li>
                    <li class="{{Request::is('admin/get-copy-right') ? 'active' : ''}}"><a href="{{route('get-copy-right')}}" class="text-uppercase text-bold"><i class="fa fa-copy"></i>Copy Right</a></li>
                </ul>
            </li>
            <li class="treeview
                        {{Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/roles') || Request::is('admin/roles/create') ? 'active' : ''}}
                    ">
                <a href="#"><i class="fa fa-first-order"></i><span class="text-uppercase text-bold">User & Permission</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/users') ? 'active' : ''}} {{Request::is('admin/users/create') ? 'active' : ''}}"><a href="{{route('users.index')}}" class="text-uppercase text-bold"><i class="fa fa-user"></i> Manage User</a></li>
                    <li class="{{Request::is('admin/roles') ? 'active' : ''}}  {{Request::is('admin/roles/create') ? 'active' : ''}}"><a href="{{route('roles.index')}}" class="text-uppercase text-bold"><i class="fa fa-cog"></i> Manage Role</a></li>
                </ul>
            </li>
            @endrole
        </ul>
    </section>
</aside>
