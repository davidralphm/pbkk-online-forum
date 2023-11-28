<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
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

            {{-- <li class="nav-item">
              <a class="nav-link disabled" href="#">
                <i class="fa fa-envelope-o">
                  <span class="badge badge-warning">11</span>
                </i>
                Disabled
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope-o">
                  <span class="badge badge-primary">11</span>
                </i>
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li> --}}
          </ul>


            <form action="/search" method="get" class="form-inline my-2 my-lg-0">
                <input type="text" name="search" id="search" placeholder="Search questions" class="form-control mr-sm-2">

                <input type="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0">
            </form>

          {{-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form> --}}
        </div>
      </nav>



    {{-- ===================================================================================== --}}


    {{-- ========================= MOST UPVOTE START =========================================================== --}}
    <div id="myBtnContainer">
        <button class="btn_filter active" onclick="filterSelection('upvotedQuestions')"> Most Upvoted Questions</button>
        <button class="btn" onclick="filterSelection('activeQuestions')"> Most Active Questions</button>
        <button class="btn" onclick="filterSelection('newestQuestions')"> Newest Questions</button>
        <button class="btn" onclick="filterSelection('upvotedUsers')"> Most Upvoted Users</button>
        <button class="btn" onclick="filterSelection('activeUsers')"> Most Active Users</button>
        <button class="btn" onclick="filterSelection('newestUsers')"> Newest Users</button>
    </div>

    <div class="container">
        <div class="filterDiv upvotedQuestions">
            <hr>
            <h2>Most Upvoted Questions of All Time</h2>
            <hr>

            @foreach ($mostUpvotedQuestions as $key => $question)
            <a href="/question/view/{{ $question->id }}">
                <h3>{{ $question->title }}</h3>
                {{-- <h4>{{ $question->replies->body }}</h4> --}}
                @if ($question->replies->count() > 0)
                    <h4>{{ $question->replies->first()->body }}</h4>
                @else
                    continue;
                @endif
            </a>

            <h5>Asked by <a href="/user/profile/{{ $question->user->id }}">{{ $question->user->name }}</a> | {{ $question->upvotes }} upvotes | {{ $question->replies->count() }} replies</h5>

            <br>
            @endforeach

        </div>

        <div class="filterDiv activeQuestions">
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
        </div>

        <div class="filterDiv newestQuestions">
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
        </div>

        <div class="filterDiv upvotedUsers">
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
        </div>

        <div class="filterDiv activeUsers">
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
        </div>

        <div class="filterDiv newestUsers">
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
        </div>
    </div>


    <script>
        function filterSelection(filterName) {
  // Get all filterDiv elements
        const filterDivs = document.querySelectorAll('.filterDiv');

        // Hide all filterDiv elements
        for (const filterDiv of filterDivs) {
            filterDiv.classList.remove('show');
        }

        // Show the filterDiv element with the specified filterName
        const targetFilterDiv = document.querySelector('.filterDiv.' + filterName);
        targetFilterDiv.classList.add('show');

        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.btn_filter');
        for (const button of buttons) {
            button.classList.remove('active');
        }

        // Add active class to the selected button
        const selectedButton = document.querySelector('.btn_filter[onclick="filterSelection(\'' + filterName + '\')"]');
        selectedButton.classList.add('active');
        }
    </script>

</body>
</html>
