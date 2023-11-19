<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Question</title>
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

    <h1>{{ $question->title }}</h1>

    @if ($question->user != null)
        <h4>Posted on {{ $question->created_at }} by {{ $question->user->name }}</h4>
    @else
        <h4>Posted on {{ $question->created_at }} by [Deleted User]</h4>
    @endif

    @if ($question->created_at != $question->updated_at)
        <h5>Edited on {{ $question->updated_at }}</h5>
    @endif

    <hr>

    @foreach ($replies as $key => $value)
        @if ($value->user != null)
            <h4>{{ $value->user->name }} wrote on {{ $value->created_at }}</h4>
        @else
            <h4>[Deleted User] wrote on {{ $value->created_at }}</h4>
        @endif

        @if ($value->created_at != $value->updated_at)
            <h5>Edited on {{ $value->updated_at }}</h5>
        @endif

        <p>
            {{ $value->body }}
        </p>

        @if (Auth::id() == $value->user_id)
            <a href="/reply/edit/{{$value->id}}">Edit</a>
        @endif

        <hr>
    @endforeach

    <h1>Reply to this question</h1>

    <form action="/question/reply/{{ $question->id }}" method="post">
        {{ csrf_field() }}

        <textarea name="body" id="" cols="30" rows="10" placeholder="Your reply"></textarea>

        <br>

        <input type="submit" value="Post">
    </form>
</body>
</html>
