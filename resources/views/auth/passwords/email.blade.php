@extends('auth._layout.layout')

@section('content')
<p class="login-box-msg">{{__("You forgot your password? Here you can easily retrieve a new password.")}}</p>

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{__("Request new password")}}</button>
        </div>
        <!-- /.col -->
    </div>
</form>

<p class="mt-3 mb-1">
    <a href="{{route('login')}}">{{__("Login")}}</a>
</p>
@endsection
