<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reply</title>
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

    <form action="/reply/edit/{{$reply->id}}" method="post">
        {{ csrf_field() }}

        <textarea name="body" id="body" cols="30" rows="10" placeholder="Your reply">@if (old('body')){{ old('body') }}@else{{ $reply->body }}@endif</textarea>

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
