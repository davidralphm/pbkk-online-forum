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

    <h1>Reports for '{{ $user->name }}'</h1>

    @if (count($reports))
        @if ($user->banned == false)
            <form action="/user/ban/{{ $user->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Ban User">
            </form>
        @else
            <form action="/user/unban/{{ $user->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Unban User">
            </form>
        @endif

        <table border="1px">
            <tr>
                <th>Reported By</th>
                <th>Reason</th>
            </tr>

            @foreach ($reports as $key => $value)
                <tr>
                    <td>{{ $value->user->name }}</td>
                    <td>{{ $value->reason }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <h2>There are no reports for this user</h2>
    @endif
</body>
</html>