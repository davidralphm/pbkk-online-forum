<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reported Replies</title>
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

    <h1>Reports for {{ $reply->user->name }}'s reply</h1>

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
</body>
</html>