<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reported Questions</title>
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

    <h1>Reports for '{{ $question->title }}'</h1>

    @if (count($reports))
        @if ($question->locked == false)
            <form action="/question/lock/{{ $question->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Lock Question">
            </form>
        @else
            <form action="/question/unlock/{{ $question->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Unlock Question">
            </form>
        @endif

        <br>

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
        <h2>There are no reports for this question</h2>
    @endif

    <!-- Navigation links -->

    @if ($reports->onFirstPage() == false)
        <a href="{{ $reports->previousPageUrl() }}">Previous</a>
    @endif

    @if ($reports->onLastPage() == false)
        <a href="{{ $reports->nextPageUrl() }}">Next</a>
    @endif
</body>
</html>