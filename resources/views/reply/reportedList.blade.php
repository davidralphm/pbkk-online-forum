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

    <h1>Reported Replies</h1>

    @if (count($reported))
        @foreach ($reported as $item)
            <h3>{{ $item[0]->reportedReply->body }} <em>[{{ count($item) }} report(s)]</em></h3>
            <a href="/reply/reportedList/view/{{ $item[0]->reportedReply->id }}">View all reports</a>

            @if ($item[0]->reportedReply->deleted == false)
                <form action="/reply/delete/{{ $item[0]->reportedReply->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Delete Reply">
                </form>
            @else
                <form action="/reply/undelete/{{ $item[0]->reportedReply->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Undelete Reply">
                </form>
            @endif
        @endforeach
    @else
        <h2>There are no reported replies.</h2>
    @endif

    @if ($reported->onFirstPage() == false)
        <a href="{{ $reported->previousPageUrl() }}">Previous</a>
    @endif

    @if ($reported->onLastPage() == false)
        <a href="{{ $reported->nextPageUrl() }}">Next</a>
    @endif
</body>
</html>