@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('submit-password') }}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id_type" value="phone">
        <div class="form-group">
            <div class="col-md-12">
                <div class="input-group mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required placeholder="Enter Your password">
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
                <div class="input-group mb-3 {{ $errors->has('confirm-password') ? ' has-error' : '' }}">
                    <input  type="password" class="form-control" name="confirm-password" value="{{ old('confirm-password') }}" required placeholder="Enter Confirm Password">
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
@endsection
