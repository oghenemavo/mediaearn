@extends('layouts.admin.auth')

@section('content')

<div class="card-inner card-inner-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Sign-In</h4>
            <div class="nk-block-des">
                <p>Access the Earners view panel using your email and passcode.</p>
            </div>
        </div>
    </div>
    <form id="authenticate" method="post" action="{{ route('admin.authenticate') }}">
        @csrf
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email">Email</label>
            </div>
            <div class="form-control-wrap">
                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
        </div>
    </form>
    <div class="form-note-s2 text-center pt-4">Forgot Password? <a href="{{ route('admin.forgot') }}">Reset Pasword Here</a>
    </div>
</div>
@endSection

@push('scripts')
    <script src="{{ asset('app/js/jquery.validate.min.js') }}"></script>

    <script>
        $(function() {
            $.validator.setDefaults({
                errorElement: "div",
                errorClass: 'invalid-feedback',
                highlight: function highlight(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function unhighlight(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function errorPlacement(error, element) {
                    error.insertAfter(element);
                }
            });

            $('#authenticate').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    }
                }
            });
        });
    </script>
@endpush