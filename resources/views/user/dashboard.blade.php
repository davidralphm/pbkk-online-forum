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

    @foreach ($user as $key => $value)
        <b>{{ $key }}</b>
    @endforeach

    <form action="/logout" method="post">
        {{ csrf_field() }}

        <input type="submit" value="Logout">
    </form>
</body>
</html>