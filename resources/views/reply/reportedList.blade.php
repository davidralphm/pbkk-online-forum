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

    @foreach ($reported as $item)
        <h3>{{ $item[0]->reportedReply->body }} <em>[{{ count($item) }} report(s)]</em></h3>
        <a href="/reply/reportedList/view/{{ $item[0]->reportedReply->id }}">View all reports</a>
    @endforeach
</body>
</html>