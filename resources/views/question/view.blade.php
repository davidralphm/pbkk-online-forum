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
    <h4>Posted on {{ $question->created_at }} by {{ $question->user->name }}</h4>

    <hr>

    @foreach ($replies as $key => $value)
        <h4>{{ $value->user->name }} wrote</h4>

        <p>
            {{ $value->body }}
        </p>

        <hr>
    @endforeach
</body>
</html>
