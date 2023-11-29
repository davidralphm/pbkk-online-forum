<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("css/dashboard.css") }}">
    {{-- <style>
        section {
        background: #659DBD;
        color: #ffffff; /* Sesuaikan warna teks agar cocok dengan latar belakang */
        }
    </style> --}}



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
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/user/home">
                <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="nav-item active">
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

    <section>
        <div class="container py-5">
          {{-- <div class="row">
            <div class="col">
              <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="/user/home">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
              </nav>
            </div>
          </div> --}}
{{-- ------------------ Foto Profile ----------------------- --}}
          <div class="row justify-content-between">
            <div class="col-lg-4">
              <div class="card mb-2">
                <div class="card-body text-center">
                    @if (!empty($user->image_url) && $user->image_url !== '')
                    <h3>Profile Image</h3>
                    <img src="/storage/uploads/{{ $user->image_url }}" alt="Profile Image" style="max-width: 150px;"><br><br>

                    <a href="/user/deleteImage">Delete profile image</a>

                    @else
                    <h3>Profile Image</h3>
                    {{-- Gunakan foto default jika foto profil tidak ada --}}
                    <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 150px;"><br><br>
                    @endif
                </div>
              </div>
            </div>

{{-- -------------- Data Diri --------------------------- --}}

            <div class="card mb-4 col-md-8">
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
{{-- -------------- row kedua --------------------------- --}}
          <div class="row">
            <div class="col-md-4">
                {{-- start edit account --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h2>Edit Account</h2>

                        <form action="/user/editAccount" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <input type="text" name="name" id="name" placeholder="Your Name"
                                @if (old('name'))
                                    value="{{ old('name') }}"
                                @else
                                    value="{{ $user->name }}"
                                @endif
                            class="input_box"><br><br>

                            <textarea name="about" id="about" cols="30" rows="10" placeholder="About">@if (old('about')){{ old('about') }}@else{{ $user->about }}@endif</textarea><br><br>

                            <label for="image" class="custom-file-upload">
                                <span>Choose profile picture</span>
                            </label>
                            <input type="file" name="image" id="image"><br><br>

                            <input type="submit" value="Save Changes" class="btn btn-outline-info">
                        </form><hr>
                    </div>
                  </div>
                </div>
                {{-- end edit account --}}

                {{-- start change password --}}
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2>Change Password</h2>

                            <form action="/user/changePassword" method="post">
                                {{ csrf_field() }}

                                <input type="password" name="password" id="password" placeholder="Current password" class="input_box"><br><br>
                                <input type="password" name="new_password" id="new_password" placeholder="New password" class="input_box"><br><br>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm new password" class="input_box"><br><br>

                                <input type="submit" value="Change Password" class="btn btn-outline-info">
                            </form><hr>

                        </div>
                    </div>
                </div>
                {{-- end change password --}}


                {{-- start delete account --}}
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2>Delete Account</h2>
                            <form action="/user/deleteAccount" method="post">
                                {{ csrf_field() }}

                                <input type="password" name="password" id="password" placeholder="Enter password" class="input_box"><br><br>

                                <input type="submit" value="Delete Account" class="btn btn-outline-warning">
                            </form><hr>

                            <a href="/logout" class="btn btn-danger mt-4">Logout</a>
                        </div>
                    </div>
                </div>
                {{-- end delete account --}}
            </div>
          </div>
    </section>

</body>
</html>
