@extends('layouts.auth')

@section('content')
    <!-- authorization form -->
    <form class="sign__form" action="{{ route('password.email') }}" method="post">
        @csrf
        <a href="index.html" class="sign__logo">
            <img src="{{ asset('app/img/logo.svg') }}" alt="">
        </a>

        <div class="sign__group">
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="sign__input" placeholder="Email">
        </div>
        
        <button class="sign__btn" type="submit">Forgot Password</button>
    </form>
    <!-- end authorization form -->
@endsection