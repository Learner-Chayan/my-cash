@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="input-group mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Please Enter Your Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
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
@endsection

