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
        @foreach ($questions as $item)
            <a href="/question/view/{{ $item->id }}">
                <h3>{{ $item->title }}</h3>
            </a>

            <h4>Asked by <a href="/user/profile/{{ $item->user->id }}">{{ $item->user->name }}</a> on {{ $item->created_at }} | {{ $item->upvotes }} upvotes | {{ $item->replies->count() }} replies</h4>
        @endforeach
    @else
        <h3>No results for '{{ Request::get('search') }}'</h3>
    @endif

    <!-- Navigation links -->

    @if ($questions->onFirstPage() == false)
        <a href="{{ $questions->previousPageUrl() }}">Previous</a>
    @endif

    @if ($questions->onLastPage() == false)
        <a href="{{ $questions->nextPageUrl() }}">Next</a>
    @endif
</body>
</html>