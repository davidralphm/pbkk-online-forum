<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("css/profilePerId.css") }} ">
</head>
<body>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <b>{{ $error }}</b>
        @endforeach
    @endif

    @if (Session::has('message-success'))
        <b>{{ Session::get('message-success') }}</b>
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



    {{-- ======================================================================= --}}
    <section>
        <div class="container py-5">
            <div class="row justify-content-between">
                <div class="col-lg-4">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        @if (!empty($user->image_url) && $user->image_url !== '')
                        <h3>Profile Image</h3>
                        <img src="/storage/uploads/{{ $user->image_url }}" alt="Profile Image" style="max-width: 150px;"><br><br>


                        @else
                        <h3>Profile Image</h3>
                        {{-- Gunakan foto default jika foto profil tidak ada --}}
                        <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 150px;"><br><br>
                        @endif
                    </div>
                </div>
                </div>

        {{-- -------------- Data Diri --------------------------- --}}

                <div class="card mb-4 col-md-8 border-0">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-0 fw-bold">Name</p>
                        </div>
                        <div class="col-sm-9">
                        {{-- <b>Name : {{ $user->name }}</b><br><hr> --}}
                        <p class="text-muted mb-0">{{ $user->name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-0 fw-bold">Email</p>
                        </div>
                        <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-0 fw-bold">Role</p>
                        </div>
                        <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $user->role }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-0 fw-bold">About</p>
                        </div>
                        <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $user->about }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-0 fw-bold">Image URL</p>
                        </div>
                        <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $user->image_url }}</p>
                        </div>
                    </div>
                    </div>

                    @if (Auth::user()->role == 'admin')
                    <h3>Reported Questions</h3>

                        @foreach ($reportedQuestions as $reportedQuestion)
                            <div>
                                <h4>
                                    {{ $reportedQuestion[0]->reportedQuestion->title }}
                                </h4>

                                <em>Number of reports : {{ count($reportedQuestion) }}</em>
                            </div>

                            <hr>
                            <br>
                        @endforeach

                        <a href="/question/reportedList/all">View All ({{ count($reportedQuestions) }})</a>

                        <hr>

                        <h3>Reported Replies</h3>

                        @foreach ($reportedReplies as $reportedReply)
                            <div>
                                <h4>
                                    {{ $reportedReply[0]->reportedReply->title }}
                                </h4>

                                <em>Number of reports : {{ count($reportedReply) }}</em>
                            </div>

                            <hr>
                            <br>
                        @endforeach

                        <a href="/reply/reportedList/all">View All ({{ count($reportedReplies) }})</a>

                        <hr>

                        <h3>Reported Users</h3>

                        @foreach ($reportedUsers as $reportedUser)
                            <div>
                                <h4>
                                    {{ $reportedUser[0]->reportedUser->title }}
                                </h4>

                                <em>Number of reports : {{ count($reportedUser) }}</em>
                            </div>

                            <hr>
                            <br>
                        @endforeach

                        <a href="/user/reportedList/all">View All ({{ count($reportedUsers) }})</a>

                        <hr>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    @if ($user->userReport() == null)
                        <a href="/user/report/{{ $user->id }}" class="btn btn-outline-danger">Report</a>

                    @else
                        <a href="/user/removeReport/{{ $user->id }}" class="btn btn-warning">Remove Report</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}

</body>
</html>
