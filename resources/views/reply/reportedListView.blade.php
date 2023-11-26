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

    @if (count($reports))
        <h1>Reports for {{ $reply->user->name }}'s reply</h1>

        @if ($reply->deleted == false)
            <form action="/reply/delete/{{ $reply->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Delete Reply">
            </form>
        @else
            <form action="/reply/undelete/{{ $reply->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Undelete Reply">
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
        <h2>There are no reports for this reply</h2>
    @endif

    @if ($reports->onFirstPage() == false)
        <a href="{{ $reports->previousPageUrl() }}">Previous</a>
    @endif

    @if ($reports->onLastPage() == false)
        <a href="{{ $reports->nextPageUrl() }}">Next</a>
    @endif
</body>
</html>