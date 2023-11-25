<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Home</h1>

    <hr>
    <h2>Search</h2>

    <form action="/search" method="get">
        <input type="text" name="search" id="search" placeholder="Search questions">

        <input type="submit" value="Search">
    </form>

    <hr>
    <h2>Newest Questions</h2>
    <hr>

    @foreach ($newestQuestions as $key => $value)
        <a href="/question/view/{{ $value->id }}">
            <h3>{{ $value->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> | {{ $value->upvotes }} upvotes</h5>

        <br>
    @endforeach

    <hr>
    <h2>Most Upvoted Questions of All Time</h2>
    <hr>

    @foreach ($mostUpvoted as $key => $value)
        <a href="/question/view/{{ $value->id }}">
            <h3>{{ $value->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> | {{ $value->upvotes }} upvotes</h5>

        <br>
    @endforeach

    <hr>
    <h2>Most Active Questions in the Last 24 Hours</h2>
    <hr>

    @foreach ($mostActive as $key => $value)
        <a href="/question/view/{{ $value[0]->question->id }}">
            <h3>{{ $value[0]->question->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value[0]->question->user->id }}">{{ $value[0]->question->user->name }}</a> | {{ $value[0]->question->upvotes }} upvotes | {{ count($value) }} new replies</h5>

        <br>
    @endforeach

    <hr>
    <h2>Newest Users in the Last 24 Hours</h2>
    <hr>

    @foreach ($newestUsers as $key => $value)
        <a href="/user/profile/{{ $value->id }}">
            <h3>{{ $value->name }}</h3>
        </a>
        
        <br>
    @endforeach
</body>
</html>