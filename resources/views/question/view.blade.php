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

    <!-- Question title -->
    <h1>{{ $question->title }}</h1>
    <h4>{{ $replies->first()->body }}</h4>

    @if ($question->user != null)
        @if ($question->created_at != $question->updated_at)
            <h5>Edited on {{ $question->updated_at }}</h5>
        @else
            <h4>{{ $question->created_at->format('d M y') }}-{{ $question->user->name }}</h4>
        @endif

    @else
        <h4>Posted on {{ $question->created_at->format('d M y') }}-[Deleted User]</h4>
    @endif

    {{-- @if ($question->created_at != $question->updated_at)
        <h5>Edited on {{ $question->updated_at }}</h5>
    @endif --}}

    @if ($question->locked == true)
        <em>This question has been locked</em>
    @else
        @if ($question->user_id == Auth::id())
            <form action="/question/lock/{{ $question->id }}" method="post">
                {{ csrf_field() }}

                <input type="submit" value="Lock Question">
            </form>
        @endif
    @endif

    @if ($question->userReport() == null)
        <a href="/question/report/{{ $question->id }}">Report</a>
        @foreach ($replies as $key => $value)
            @if ($loop->first)
                @if ($value->userVote() != null)
                    @if ($value->userVote()->type == 'upvote')
                        <em>You upvoted this reply</em>
                        <a href="/reply/downvote/{{ $value->id }}">Downvote</a>
                    @else
                        <em>You downvoted this reply</em>
                        <a href="/reply/upvote/{{ $value->id }}">Upvote</a>
                    @endif

                    <a href="/reply/unvote/{{ $value->id }}">Remove vote</a>
                @else
                    <a href="/reply/upvote/{{ $value->id }}">Upvote</a>
                    <a href="/reply/downvote/{{ $value->id }}">Downvote</a>
                @endif
            @else
                @break
            @endif
        @endforeach
    @else
        <a href="/question/removeReport/{{ $question->id }}">Remove Report</a>
    @endif

    <hr>

    <!-- Replies -->
    @foreach ($replies as $key => $value)
        @if ($loop->first)
            @continue
        @endif
        <!-- Handle deleted user -->
        @if ($value->user != null)
            <h4>{{ $value->user->name }} wrote on {{ $value->created_at }}</h4>
        @else
            <h4>[Deleted User] wrote on {{ $value->created_at }}</h4>
        @endif

        @if ($value->created_at != $value->updated_at)
            <h5>Edited on {{ $value->updated_at }}</h5>
        @endif

        @if ($value->deleted == false)
            <p>
                {{ $value->body }}
            </p>

            <!-- Voting -->
            @if ($value->userVote() != null)
                @if ($value->userVote()->type == 'upvote')
                    <em>You upvoted this reply</em>
                    <a href="/reply/downvote/{{ $value->id }}">Downvote</a>
                @else
                    <em>You downvoted this reply</em>
                    <a href="/reply/upvote/{{ $value->id }}">Upvote</a>
                @endif

                <a href="/reply/unvote/{{ $value->id }}">Remove vote</a>
            @else
                <a href="/reply/upvote/{{ $value->id }}">Upvote</a>
                <a href="/reply/downvote/{{ $value->id }}">Downvote</a>
            @endif

            <!-- Reporting -->
            @if ($value->userReport() == null)
                <a href="/reply/report/{{ $value->id }}">Report</a>
            @else
                <a href="/reply/removeReport/{{ $value->id }}">Remove Report</a>
            @endif

            <!-- Editing -->
            @if (Auth::id() == $value->user_id)
                <a href="/reply/edit/{{ $value->id }}">Edit</a>

                <form action="/reply/delete/{{ $value->id }}" method="post">
                    {{ csrf_field() }}

                    <input type="submit" value="Delete Reply">
                </form>
            @endif
        @else
            <em>This reply was deleted</em>
        @endif

        <hr>
    @endforeach

    <!-- Reply form -->
    @if ($question->locked == false)
        <h1>Reply to this question</h1>

        <form action="/question/reply/{{ $question->id }}" method="post">
            {{ csrf_field() }}

            <textarea name="body" id="" cols="30" rows="10" placeholder="Your reply"></textarea>

            <br>

            <input type="submit" value="Post">
        </form>
    @else
        <h3>This question has been locked</h3>
        <h3>You cannot reply to it</h3>
    @endif

    <!-- Previous and next page links -->
    @if (!$replies->onFirstPage())
        <a href="{{ $replies->previousPageUrl() }}">Previous</a>
    @endif

    @if (!$replies->onLastPage())
        <a href="{{ $replies->nextPageUrl() }}">Next</a>
    @endif

    <script>
        // Tanggal dan waktu dari PHP Blade
        var dateTimeString = "{{ $question->created_at }}";
        var dateTime = new Date(dateTimeString);

        // Mengonversi format tanggal
        var optionsDate = { day: '2-digit', month: 'short', year: '2-digit' };
        var formattedDate = dateTime.toLocaleDateString('en-US', optionsDate); // '28 Nov 23'

        // Menyusun hasil
        var result = formattedDate;

        // Menampilkan hasil di console atau di HTML sesuai kebutuhan Anda
        console.log(result);

        // Jika ingin menampilkan hasil di HTML, tambahkan elemen HTML yang sesuai
        // contohnya:
        // document.getElementById('result').innerHTML = result;
    </script>
</body>
</html>
