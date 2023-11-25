<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Question</title>
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

    <h1>Report Question</h1>

    <h2>Report '{{ $question->title }}'</h2>

    <hr>

    <form action="/question/report/{{ $question->id }}" method="post">
        {{ csrf_field() }}

        <textarea name="reason" id="reason" cols="30" rows="10" placeholder="Reporting reason"></textarea>

        <br>

        <input type="submit" value="Report Question">
    </form>
</body>
</html>