<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reported Users</title>
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

    <h1>Reported Users</h1>

    @if (count($reported))
        @foreach ($reported as $item)
            <h3>{{ $item[0]->reportedUser->name }} <em>[{{ count($item) }} report(s)]</em></h3>
            <a href="/user/reportedList/view/{{ $item[0]->reportedUser->id }}">View all reports</a>

            @if ($item[0]->reportedUser->banned == false)
                <form action="/user/ban/{{ $item[0]->reportedUser->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Ban User">
                </form>
            @else
                <form action="/user/unban/{{ $item[0]->reportedUser->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Unban User">
                </form>
            @endif
        @endforeach
    @else
        <h2>There are no reported users</h2>
    @endif
</body>
</html>