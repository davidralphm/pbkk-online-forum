<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban User '{{ $user->name }}'</title>
</head>
<body>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <b>{{ $error }}</b><br><hr>
        @endforeach
    @endif

    @if (Session::has('message-success'))
        <b>{{ Session::get('message-success') }}</b><br><hr>
    @endif
    
    <h1>Ban User '{{ $user->name }}'</h1>

    @if ($user->banned == false)
        <form action="/user/ban/{{ $user->id }}" method="post">
            {{ csrf_field() }}
            
            <input type="datetime-local" name="banned_until" id="banned_until">
            <input type="submit" value="Ban User">
        </form>
    @else
        <h2>User is already banned.</h2>

        <form action="/user/unban/{{ $user->id }}" method="post">
            {{ csrf_field() }}

            <input type="submit" value="Unban user">
        </form>
    @endif
</body>
</html>