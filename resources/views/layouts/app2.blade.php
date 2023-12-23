<html>
<head>
    <title>{{$page_title}} | {{$site_title}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/admin/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/favicon.png') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

<div class="login-box">
    <!-- /.login-logo -->
    <h4 class="text-center"><img src="{{ asset('public/favicon.png') }}" alt=""></h4>

    <div class="login-box-body">
        <label for=""></label>
        <h1 class="text-center" style="font-family: 'Fira Code'">{{$site_title}}</h1>
        <hr>
        @if (session()->has('message'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session()->get('message') }}
            </div>
        @endif
        @if($errors->any())
            @foreach ($errors->all() as $error)

                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!!  $error !!}
                </div>
            @endforeach
        @endif

        @yield('content')
    </div>
</div>

<script src="{{asset('/assets/admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

</body>
</html>