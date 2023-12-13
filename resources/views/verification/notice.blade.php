@extends('layouts.app')

@section('content')

    <!-- page title -->
    <section class="section section--first section--bg" data-bg="/app/img/section/section.jpg">
        <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('resent'))
                    <div class="alert alert-icon alert-success" role="alert">
                        <em class="icon ni ni-alert-circle"></em>
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p class="section__text">
                    <span class="s1">
                    Before proceeding, please check your email for a verification link. If you did not receive the email,
                    </span>
                </p>

                <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="sign__btn">
                        click here to request another
                    </button>.
                </form>
            </div>
        </div>
    </section>

@endsection
