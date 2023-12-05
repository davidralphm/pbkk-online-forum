<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Questions</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset('css/searchPage.css') }}" rel="stylesheet">
</head>
<body>

    {{-- ======================================================== --}}

    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/user/home">
                <i class="fa fa-home"></i>
                <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/profile">
                <i class="fa fa-user">
                  <span class="badge badge-danger"></span>
                </i>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/question/notifications">
                  <i class="fa fa-bell">
                      <span class="badge badge-danger">{{ $unreadCount }}</span>
                  </i>
                </a>
              </li>


            <li class="nav-item">
                <a class="nav-link disabled" href="/question/create">
                    <button type="button" class="btn btn-outline-success btn-sm">Create Post</button>
                </a>
            </li>
          </ul>


            <form action="/search" method="get" class="form-inline my-2 my-lg-0 mr-3">
                <input type="text" name="search" id="search" placeholder="Search questions" class="form-control mr-sm-2" style="margin-right: 40px;">

                <input type="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0">
            </form>

            <a href="/logout" class="btn btn-danger form-inline my-2 my-lg-0">Logout</a>
        </div>
      </nav>

    {{-- ======================================================== --}}

    <div class="container">
        <h2>Results for '{{ Request::get('search') }}'</h2>

        <hr>

        @if (count($questions))
            @foreach ($questions as $item)
                {{-- ============================================================== --}}

                <div class="card mb-4">
                    <div class="card-body text">
                        {{-- ======================================================================= --}}
                                <div  style="display: flex; align-items: center;">

                                    @if (!empty($item->user->image_url) && $item->user->image_url !== '')

                                        <a class="nav-link disabled" href="/user/profile/{{ $item->user->id }}">
                                            <img src="/storage/uploads/{{ $item->user->image_url }}" alt="Profile Image" style="max-width: 60px; border-radius: 50%; margin-right: 10px" >
                                        </a>

                                    @else
                                        {{-- Gunakan foto default jika foto profil tidak ada --}}
                                        <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 70px; border-radius: 50%; margin-right: 10px"><br><br>
                                    @endif


                                    <div>
                                        <a href="/user/profile/{{ $item->user->id }}">
                                            <h4 style="text-transform: capitalize; margin-bottom: 0; font-size: 20px; color: black;">{{ $item->user->name }}</h4>
                                        </a>

                                        @if ($item->user != null)
                                            <h7 style="font-size: 14px; font-weight: normal;">Wrote on {{ $item->created_at->format('d M y . H:i') }}</h7><br>
                                        @else
                                            <h4>Posted on {{ $item->created_at }}-[Deleted User]</h4>
                                        @endif
                                    </div>
                                </div>
                                <hr style="2px solid">

                                <a href="/question/view/{{ $item->id }}">
                                    <h3 style="color: black; text-transform: capitalize;">{{ $item->title }}</h3>
                                    @if ($item->replies->count() > 0)
                                        <p style="color: black;">{{ $item->replies->first()->body }}</p>
                                    @else
                                        continue;
                                    @endif
                                </a>

                                <div>
                                    <h5>{{ $item->upvotes }} upvotes | {{ $item->replies->count() }} replies</h5>
                                    <br>
                                </div>

                        {{-- ======================================================================= --}}
                    </div>
                </div>

                {{-- ============================================================== --}}
                {{-- <a href="/question/view/{{ $item->id }}">
                    <h3>{{ $item->title }}</h3>
                </a>

                <h4>Asked by <a href="/user/profile/{{ $item->user->id }}">{{ $item->user->name }}</a> on {{ $item->created_at }} | {{ $item->upvotes }} upvotes | {{ $item->replies->count() }} replies</h4> --}}
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
    </div>


</body>
</html>
