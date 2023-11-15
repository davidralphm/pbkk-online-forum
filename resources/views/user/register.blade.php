<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <b>{{ $error }}</b>
        @endforeach
    @endif

    @if (Session::has('message-success'))
        <b>{{ Session::get('message-success') }}</b>
    @endif

    <form action="/register" method="post">
        {{ csrf_field() }}

        <input type="text" name="name" id="name" placeholder="name">
        <input type="email" name="email" id="email" placeholder="email">
        <input type="password" name="password" id="password" placeholder="password">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">

        <input type="submit" value="Register">
    </form>
</body>
</html>