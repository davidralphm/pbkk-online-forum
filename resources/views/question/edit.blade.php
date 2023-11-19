<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
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

    <h1>Edit Question</h1>

    <form action="/question/edit/{{ $question->id }}" method="post">
        {{ csrf_field() }}

        <input type="text" name="title" id="title" placeholder="Question Title"
            @if (old('title'))
                value="{{ old('title') }}"
            @else
                value="{{ $question->title }}"
            @endif
        ><br><br>

        <input type="submit" value="Edit question">
    </form>
</body>
</html>
