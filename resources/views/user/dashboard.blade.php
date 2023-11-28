<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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

    <section style="background-color: rgb(0, 60, 109);">
        <div class="container py-5">
          <div class="row">
            <div class="col">
              <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="/user/home">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
              </nav>
            </div>
          </div>
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
                      <p class="mb-0">Name</p>
                    </div>
                    <div class="col-sm-9">
                      {{-- <b>Name : {{ $user->name }}</b><br><hr> --}}
                      <p class="text-muted mb-0">{{ $user->name }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Role</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $user->role }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">About</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $user->about }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Image URL</p>
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
                            ><br><br>

                            <textarea name="about" id="about" cols="30" rows="10" placeholder="About">@if (old('about')){{ old('about') }}@else{{ $user->about }}@endif</textarea><br><br>

                            <label for="image" class="custom-file-upload">
                                <span>Choose profile picture:</span>
                            </label>
                            <input type="file" name="image" id="image" ><br><br>

                            <input type="submit" value="Save Changes">
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

                                <input type="password" name="password" id="password" placeholder="Current password"><br><br>
                                <input type="password" name="new_password" id="new_password" placeholder="New password"><br><br>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm new password"><br><br>

                                <input type="submit" value="Change Password">
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

                                <input type="password" name="password" id="password" placeholder="Enter password"><br><br>

                                <input type="submit" value="Delete Account">
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
