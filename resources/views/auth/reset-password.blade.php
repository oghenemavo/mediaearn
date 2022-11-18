<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

{{ session()->get('status') }}
{{ session()->get('errors') }}

    <form action="{{ route('password.update') }}" method="post">
        @csrf
        
        <input type="hidden" id="token" name="token" value="{{ $token }}">
        <input type="hidden" id="email" name="email" value="{{ request()->query('email') }}">
        <br>
        <input type="password" id="password" name="password">
        <br>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>