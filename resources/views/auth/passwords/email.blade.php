@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('send-otp') }}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id_type" value="email">
        <div class="form-group">
            <div class="col-md-12">
                <div class="input-group mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Enter Your Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">
                    Reset Password
                </button>
            </div>
        </div>
    </form><div class="row">
        <!-- /.col -->
        <div class="col-12">
            <p class="mt-4">
                <a class="btn btn-warning btn-block" href="{{route('send-otp-phone')}}">Using Phone</a>
            </p>
        </div>
        <!-- /.col -->
    </div>

@endsection

