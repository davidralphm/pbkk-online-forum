<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
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

    <h1>Create Question</h1>

    <form action="/question/create" method="post">
        {{ csrf_field() }}

        <input type="text" name="title" id="title" placeholder="Question Title"><br><br>

        <textarea name="body" id="body" cols="30" rows="10" placeholder="Question Body"></textarea><br><br>

        <input type="submit" value="Create question">
    </form>
</body>
</html>
