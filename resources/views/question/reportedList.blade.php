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

    <h1>Reported Questions</h1>

    @if (count($reported))
        @foreach ($reported as $item)
            <h3>
                <a href="/question/view/{{ $item[0]->reportedQuestion->id }}">
                    {{ $item[0]->reportedQuestion->title }}
                </a>

                <em>[{{ count($item) }} report(s)]</em>
            </h3>
            <a href="/question/reportedList/view/{{ $item[0]->reportedQuestion->id }}">View all reports</a>

            @if ($item[0]->reportedQuestion->locked == false)
                <form action="/question/lock/{{ $item[0]->reportedQuestion->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Lock Question">
                </form>
            @else
                <form action="/question/unlock/{{ $item[0]->reportedQuestion->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Unlock Question">
                </form>
            @endif
        @endforeach
    @else
        <h2>There are no reported questions</h2>
    @endif
</body>
</html>