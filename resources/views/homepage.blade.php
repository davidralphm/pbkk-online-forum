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
    <h2>Most Upvoted Questions of All Time</h2>
    <hr>

    @foreach ($mostUpvotedQuestions as $key => $value)
        <a href="/question/view/{{ $value->id }}">
            <h3>{{ $value->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> | {{ $value->upvotes }} upvotes | {{ $value->replies->count() }} replies</h5>

        <br>
    @endforeach

    <hr>
    <h2>Most Active Questions in the Last 24 Hours</h2>
    <hr>

    @foreach ($mostActiveQuestions as $value)
        <a href="/question/view/{{ $value[0]->id }}">
            <h3>{{ $value[0]->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value[0]->user->id }}">{{ $value[0]->user->name }}</a> | {{ $value[0]->upvotes }} upvotes | {{ count($value) }} new replies</h5>

        <br>
    @endforeach

    <hr>
    <h2>Newest Questions</h2>
    <hr>

    @foreach ($newestQuestions as $key => $value)
        <a href="/question/view/{{ $value->id }}">
            <h3>{{ $value->title }}</h3>
        </a>
        
        <h5>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> | {{ $value->upvotes }} upvotes | {{ $value->replies->count() }} replies</h5>

        <br>
    @endforeach

    <hr>
    <h2>Most Upvoted Users in the Last 24 Hours</h2>
    <hr>

    @foreach ($mostUpvotedUsers as $item)
        <a href="/user/profile/{{ $item[0]->id }}">
            <h3>{{ $item[0]->name }}</h3>
        </a>

        <p>{{ count($item) }} new upvotes</p>
        
        <br>
    @endforeach

    <hr>
    <h2>Most Active Users in the Last 24 Hours</h2>
    <hr>

    @foreach ($mostActiveUsers as $item)
        <a href="/user/profile/{{ $item[0]->id }}">
            <h3>{{ $item[0]->name }}</h3>
        </a>

        <p>{{ count($item) }} new replies posted</p>
        
        <br>
    @endforeach

    <hr>
    <h2>Newest Users in the Last 24 Hours</h2>
    <hr>

    @foreach ($newestUsers as $key => $value)
        <a href="/user/profile/{{ $value->id }}">
            <h3>{{ $value->name }}</h3>
        </a>

        <p>Joined on {{ $value->created_at }}</p>
        
        <br>
    @endforeach
</body>
</html>