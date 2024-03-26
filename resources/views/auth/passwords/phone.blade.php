@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('send-otp') }}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id_type" value="phone">
        <div class="form-group">
            <div class="col-md-12">
                <div class="input-group mb-3 {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Enter Your Phone number">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
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
    </form>
    <div class="row">
        <!-- /.col -->
        <div class="col-12">
            <p class="mt-4">
                <a class="btn btn-warning btn-block" href="{{route('send-otp-email')}}">Using Email</a>
            </p>
        </div>
        <!-- /.col -->
    </div>
@endsection

