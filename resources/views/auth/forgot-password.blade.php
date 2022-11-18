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
{{ session()->get('email') }}

    <form action="{{ route('password.email') }}" method="post">
        @csrf
        
        <input type="email" id="email" name="email" value="{{ old('email') }}">

        <button type="submit">Forgot Password</button>
    </form>
</body>
</html>