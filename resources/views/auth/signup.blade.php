@extends('layouts.auth')

@section('content')
    <!-- authorization form -->
    <form class="sign__form" action="{{ route('user.create') }}" method="post">
        @csrf
        <a href="index.html" class="sign__logo">
            <img src="{{ asset('app/img/logo.svg') }}" alt="">
        </a>

        <input type="hidden" name="referral_id" value="{{ $referral_id ?? '' }}">

        <div class="sign__group">
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="sign__input" placeholder="First Name">
        </div>

        <div class="sign__group">
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="sign__input" placeholder="Last Name">
        </div>

        <div class="sign__group">
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="sign__input" placeholder="Email">
        </div>

        <div class="sign__group">
            <input type="password" id="password" name="password" class="sign__input" placeholder="Password">
        </div>

        <div class="sign__group sign__group--checkbox">
            <input name="terms" id="terms" type="checkbox" checked="checked">
            <label for="terms">Accept Terms</label>
        </div>
        
        <button class="sign__btn" type="submit">Sign up</button>

        <span class="sign__text">Already have an account? <a href="{{ route('login.page') }}">Sign in!</a></span>
    </form>
    <!-- end authorization form -->
@endsection