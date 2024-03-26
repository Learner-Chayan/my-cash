@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('match-otp') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-md-12">
                <div class="input-group mb-3 {{ $errors->has('otp') ? ' has-error' : '' }}">
                    <input id="text" type="text" class="form-control" name="otp" value="{{ old('otp') }}" required placeholder="Enter Your OTP">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">
                    Submit
                </button>
            </div>
        </div>
    </form>
{{--    <div class="row">--}}
{{--        <!-- /.col -->--}}
{{--        <div class="col-12">--}}
{{--            <p class="mt-4">--}}
{{--                <a class="btn btn-warning" href="{{route('send-otp-email')}}">Re-send</a>--}}
{{--            </p>--}}
{{--        </div>--}}
{{--        <!-- /.col -->--}}
{{--    </div>--}}
@endsection
