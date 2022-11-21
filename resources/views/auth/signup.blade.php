<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('user.create') }}" method="post">
        @csrf
        
        <input type="hidden" name="referral_id" value="{{ $referral_id ?? '' }}">

        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autofocus>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}">
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        <input type="password" id="password" name="password" value="{{ old('password') }}">

        <input type="checkbox" name="terms" id="terms">

        <button type="submit">Sign up</button>
    </form>
</body>
</html>