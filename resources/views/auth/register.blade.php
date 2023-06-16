@extends('layouts.auth-master')

@section('content')

<style>
body {
    background-color: #ffebeb;
    font-family: Arial, sans-serif;
  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .login-form {
    background-color: #FFFFFF;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 320px;
  }

  .login-form h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #555555;
  }

  .login-form input[type="text"],
  .login-form input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #DDDDDD;
    border-radius: 4px;
    margin-bottom: 20px;
  }

  .login-form button {
    background-color: #FFC0CB;
    border: none;
    color: #FFFFFF;
    padding: 12px 20px;
    border-radius: 4px;
    width: 100%;
    cursor: pointer;
    font-size: 16px;
  }

  .login-form button:hover {
    background-color: #FFB6C1;
  }

  .login-form p {
    text-align: center;
    margin-top: 20px;
  }

  .login-form p a {
    color: #555555;
    text-decoration: none;
  }</style>

<div class="container">
    <form class="login-form" method="post" action="{{ route('register.perform') }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
       
        <h1 class="h3 mb-3 fw-normal">Register</h1>

        <div class="form-group form-floating mb-3">
        <label for="floatingEmail">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
        <label for="floatingName">Username</label>
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        
        <div class="form-group form-floating mb-3">
        <label for="floatingPassword">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
        <label for="floatingConfirmPassword">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
                    @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        
        @include('auth.partials.copy')
    </form>
</div>
@endsection