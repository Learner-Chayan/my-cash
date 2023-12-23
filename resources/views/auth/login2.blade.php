@extends('layouts.app')

@section('content')
    @if(env('SOCIAL_LOGIN'))
        <div class="social-auth-links text-center">
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="{{ url('auth/google') }}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>
    @endif
    <h3 class="text-center text-uppercase" style="color:indianred;font-family: 'Droid Serif';">{{$page_title}}</h3>
    <form class="" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" required placeholder="Enter Your Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" required placeholder="Enter Your Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn bg-blue-gradient btn-block btn-flat" style="font-size: 22px; font-family: 'Fira Code'">Login</button>
                <hr>
            </div>
        </div>
    </form>
    <div class="social-auth-links text-center">
        <a href="{{route('password.request')}}" class="btn btn-social btn-block btn-file bg-green-gradient btn-flat"><i class="fa fa-lock"></i> Forget Password</a>
        @if(env('REGISTRATION_STATUS'))
            <a href="{{route('register')}}" class="btn btn-block btn-social bg-maroon-gradient btn-flat"><i class="fa fa-user-plus"></i> Sign in</a>
        @endif
    </div>
    <!-- /.social-auth-links -->
@endsection
