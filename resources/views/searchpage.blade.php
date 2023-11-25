<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Questions</title>
</head>
<body>
    <h1>Search Questions</h1>
    <h2>Results for '{{ Request::get('search') }}'</h2>

    <hr>

    @if (count($questions))
        @foreach ($questions as $key => $value)
            <a href="/question/view/{{ $value->id }}">
                <h3>{{ $value->title }}</h3>
            </a>

            <h4>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> on {{ $value->created_at }}, {{ $value->upvotes }} upvotes</h4>
        @endforeach
    @else
        <h3>No results for '{{ Request::get('search') }}'</h3>
    @endif
</body>
</html>