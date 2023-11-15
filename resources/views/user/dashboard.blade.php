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

    <b>Name : {{ $user->name }}</b><br><hr>
    <b>Email : {{ $user->email }}</b><br><hr>
    <b>Role : {{ $user->role }}</b><br><hr>
    <b>About : {{ $user->about }}</b><br><hr>
    <b>Image URL : {{ $user->image_url }}</b><br><hr>

    <form action="/logout" method="post">
        {{ csrf_field() }}

        <input type="submit" value="Logout">
    </form>
</body>
</html>
