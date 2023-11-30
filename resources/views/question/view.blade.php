<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Question</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("css/viewPerPage.css") }} ">
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
    {{-- START NAVBAR --}}
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/user/home">
                <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/profile">
                <i class="fa fa-user">
                    <span class="sr-only">(current)</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="/question/create">
                    <button type="button" class="btn btn-outline-success btn-sm">Create Post</button>
                </a>
            </li>
          </ul>


            <form action="/search" method="get" class="form-inline my-2 my-lg-0">
                <input type="text" name="search" id="search" placeholder="Search questions" class="form-control mr-sm-2">

                <input type="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0">
            </form>
        </div>
    </nav>
    {{-- END NAVBAR --}}

{{-- START CONTAINER QUESTION --}}
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">

                <hr style="border: 2px solid #000;">
                <!-- Question title -->
                <div  style="display: flex; align-items: center;">

                        @if (!empty($question->user->image_url) && $question->user->image_url !== '')

                            <a class="nav-link disabled" href="/user/profile/{{ $question->user->id }}">
                                <img src="/storage/uploads/{{ $question->user->image_url }}" alt="Profile Image" style="max-width: 70px; border-radius: 50%; margin-right: 10px" >
                            </a>

                        @else
                            {{-- Gunakan foto default jika foto profil tidak ada --}}
                            <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 70px; border-radius: 50%; margin-right: 10px"><br><br>
                        @endif


                        <div>
                            <h4 style="text-transform: capitalize; margin-bottom: 0; font-size: 20px;">{{ $question->user->name }}</h4>
                            @if ($question->user != null)
                                @if ($question->created_at != $question->updated_at)
                                    <h7 style="font-size: 14px; font-weight: normal;">Wrote on {{ $question->created_at->format('d M y . H:i') }}</h7><br>
                                    <h7 style="font-size: 14px; font-weight: normal;">Edited on {{ $question->updated_at->format('d M y . H:i') }}</h7>
                                @else
                                    <h7>Wrote on {{ $question->created_at->format('d M y . H:i') }}</h7>
                                @endif

                            @else
                                <h4>Posted on {{ $question->created_at->format('d M y . H:i') }}-[Deleted User]</h4>
                            @endif
                        </div>

                </div>
                <hr style="border: 0.5px solid #000;">

                <h1 style="text-transform: capitalize;">{{ $question->title }}</h1>
                <h4>{{ $replies->first()->body }}</h4>

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

                <hr style="border: 2px solid #000;"

                <!-- Replies -->
                @foreach ($replies as $key => $value)
                    @if ($loop->first)
                        @continue
                    @endif

                    <div  style="display: flex; align-items: center;">
                        @if (!empty($value->user->image_url) && $value->user->image_url !== '')
                            <a class="nav-link disabled" href="/user/profile/{{ $value->user->id }}">
                                <img src="/storage/uploads/{{ $value->user->image_url }}" alt="Profile Image" style="max-width: 50px; border-radius: 50%; margin-right: 10px">
                            </a>
                        @else
                            {{-- Gunakan foto default jika foto profil tidak ada --}}
                            <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 50px; border-radius: 50%; margin-right: 10px"><br><br>
                        @endif
                        {{-- <img src="/storage/uploads/{{ $question->user->image_url }}" alt="Profile Image" style="max-width: 80px; border-radius: 50%; margin-right: 10px" > --}}

                        <div>
                            <h4 style="text-transform: capitalize; font-size: 18px;">{{ $value->user->name }}</h4>
                            @if ($value->user != null)
                                @if ($value->created_at != $value->updated_at)
                                    <h6 style="font-size: 12px; font-weight: normal;">Wrote on {{ $value->created_at->format('d M y . H:i') }}</h6>
                                    <h6 style="font-size: 12px; font-weight: normal;">Edited on {{ $value->updated_at->format('d M y . H:i') }}</h6>
                                @else
                                    <h6 style="font-size: 12px; font-weight: normal;">Wrote on {{ $value->created_at->format('d M y . H:i') }}</h6>
                                @endif

                            @else
                                <h4>Posted on {{ $value->created_at->format('d M y . H:i') }}-[Deleted User]</h4>
                            @endif
                        </div>
                    </div>
                    {{-- <hr style="border: 0.2px dash #000;"> --}}


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

                    <hr style="border: 1.5px solid #000;">
                @endforeach

                <!-- Reply form -->
                @if ($question->locked == false)
                    <h1 style="font-size: 24px">Reply to this question</h1>

                    <form action="/question/reply/{{ $question->id }}" method="post" style="margin-bottom: 20px">
                        {{ csrf_field() }}

                        <textarea name="body" id="" cols="30" rows="10" placeholder="Your reply" style="border-radius: 30px; padding:20px; margin-bottom: 10px;"></textarea>

                        <br>

                        <input type="submit" value="Post" class="btn btn-outline-primary">
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
            </div>
        </div>
    </div>


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
        // console.log(result);
    </script>
</body>
</html>
