@extends('layouts.auth')

@section('content')
    <!-- authorization form -->
    <form class="sign__form" action="{{ route('password.update') }}" method="post">
        @csrf
        <a href="{{ route('home') }}" class="sign__logo">
            <img src="{{ asset('assets/images/earners-logo.png') }}" width="100" height="100" alt="earners view logo">
        </a>

        <input type="hidden" id="token" name="token" value="{{ $token }}">
        <input type="hidden" id="email" name="email" value="{{ request()->query('email') }}">

        <div class="sign__group">
            <input type="password" id="password" name="password" class="sign__input" placeholder="Password">
        </div>

        <div class="sign__group">
            <input type="password" id="password_confirmation" name="password_confirmation" class="sign__input" placeholder="password_confirmation">
        </div>
        
        <button class="sign__btn" type="submit">Reset Password</button>
    </form>
    <!-- end authorization form -->
@endsection