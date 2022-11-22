@extends('layouts.admin.auth')

@section('content')

    {{ session()->get('status') }}
    {{ session()->get('email') }}

<div class="card-inner card-inner-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Forgot Password</h4>
            <div class="nk-block-des">
                <p>Request for reset of forgotten password.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.request.reset') }}">
        @csrf
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email">Email</label>
            </div>
            <div class="form-control-wrap">
                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Enter your email address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Request Password Reset</button>
        </div>
    </form>
</div>
@endSection