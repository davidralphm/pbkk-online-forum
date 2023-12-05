<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("css/createQuestion.css") }} ">
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
                <i class="fa fa-home fa-color-blue"></i>
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
    {{-- END NAVBAR --}}

    <div class="bjir">
        <div class="woy">
            <h1>Create Question</h1>
            <hr style="border: 0.5px solid #000; width: 100%">

            <div class="flash-message-container" style="margin-top: 15px">
                @if (Session::has('message-success'))
                    <div class="flash-message">
                        {{ Session::get('message-success') }}
                    </div>
                @endif
            </div>

        <form action="/question/create" method="post">
            {{ csrf_field() }}

            <input type="text" name="title" id="title" placeholder="Question Title" style="border-radius: 20px; padding:20px; margin-bottom: 10px; width: 100%"><br><br>

            <textarea name="body" id="body" cols="30" rows="10" placeholder="Question Body" style="border-radius: 30px; padding:20px; margin-bottom: 10px; width: 100%"></textarea><br><br>

            <input type="submit" value="Create question" class="btn btn-outline-secondary">

        </form>
        </div>
    </div>

</body>
</html>
