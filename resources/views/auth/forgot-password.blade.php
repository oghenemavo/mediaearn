@extends('layouts.auth')

@section('content')
    <!-- authorization form -->
    <form class="sign__form" action="{{ route('password.email') }}" method="post">
        @csrf
        <a href="{{ route('home') }}" class="sign__logo">
            <img src="{{ asset('assets/images/earners-logo.png') }}" width="100" height="100" alt="earners view logo">
        </a>

        <div class="sign__group">
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="sign__input" placeholder="Email">
            @error('email')
            <div style="color: red; font-size:12px">
            {{ $message }}
            </div>
            @enderror
        </div>
        
        <button class="sign__btn" type="submit">Forgot Password</button>
    </form>
    <!-- end authorization form -->
@endsection