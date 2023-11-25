<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Reply</title>
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

    <h1>Report Reply</h1>

    <h2>Report {{ $reply->user->name }}'s reply</h2>

    <hr>

    <form action="/reply/report/{{ $reply->id }}" method="post">
        {{ csrf_field() }}

        <textarea name="reason" id="reason" cols="30" rows="10" placeholder="Reporting reason"></textarea>

        <br>

        <input type="submit" value="Report Reply">
    </form>
</body>
</html>