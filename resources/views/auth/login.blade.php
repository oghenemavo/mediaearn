<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('user.login') }}" method="post">
        @csrf
        
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        <input type="password" id="password" name="password" value="{{ old('password') }}">

        <input type="checkbox" name="remember" id="remember">

        <button type="submit">Log in</button>
    </form>
</body>
</html>