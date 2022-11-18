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

    <form action="{{ route('change.password') }}" method="post">
        @csrf
        
        <input type="password" id="current_password" name="current_password">
        <br>

        <input type="password" id="password" name="password">
        <br>
        
        <input type="password" id="password_confirmation" name="password_confirmation">
        <br>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>