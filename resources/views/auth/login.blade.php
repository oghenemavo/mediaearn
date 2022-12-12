@extends('layouts.auth')

@section('content')
    <!-- authorization form -->
    <form class="sign__form" action="{{ route('login') }}" method="post">
        @csrf
        <a href="{{ route('home') }}" class="sign__logo">
            <img src="{{ asset('assets/images/earners-logo.png') }}" width="100" height="100" alt="earners view logo">
        </a>

        <div class="sign__group">
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="sign__input" placeholder="Email">
        </div>

        <div class="sign__group">
            <input type="password" id="password" name="password" class="sign__input" placeholder="Password">
        </div>

        <div class="sign__group sign__group--checkbox">
            <input id="remember" name="remember" type="checkbox" checked="checked">
            <label for="remember">Remember Me</label>
        </div>
        
        <button class="sign__btn" type="submit">Sign in</button>

        <span class="sign__text">Don't have an account? <a href="{{ route('signup.page') }}">Sign up!</a></span>

        <span class="sign__text"><a href="{{ route('password.request') }}">Forgot password?</a></span>
    </form>
    <!-- end authorization form -->
@endsection