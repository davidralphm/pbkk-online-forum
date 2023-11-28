<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 20px;
        }

        #dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            /* Menengahkan vertikal */
            /* align-items: center;  */
            flex-direction: row;
            justify-content: center; /* Menengahkan horizontal */
            /* text-align: center; */
            margin: auto; /* Menengahkan container secara keseluruhan */
        }


        #profile-image-container {
            margin-right: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>

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

    <div class="container" id="dashboard-container">
        {{-- <div id="profile">
            <h2 class="mb-4">Profile</h2>
        </div> --}}

        <div id="profile-image-container">
            @if (!empty($user->image_url) && $user->image_url !== '')
            <h3>Profile Image</h3>
            <img src="/storage/uploads/{{ $user->image_url }}" alt="Profile Image" style="max-width: 200px;"><br><br>

            <a href="/user/deleteImage">Delete profile image</a>
            @endif

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

                <input type="file" name="image" id="image"><br><br>

                <input type="submit" value="Save Changes">
            </form><hr>
        </div>


        <div>
            <b>Name : {{ $user->name }}</b><br><hr>
            <b>Email : {{ $user->email }}</b><br><hr>
            <b>Role : {{ $user->role }}</b><br><hr>
            <b>About : {{ $user->about }}</b><br><hr>
            <b>Image URL : {{ $user->image_url }}</b><br><hr>

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





            <h2>Change Password</h2>

            <form action="/user/changePassword" method="post">
                {{ csrf_field() }}

                <input type="password" name="password" id="password" placeholder="Current password"><br><br>
                <input type="password" name="new_password" id="new_password" placeholder="New password"><br><br>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm new password"><br><br>

                <input type="submit" value="Change Password">
            </form><hr>

            <h2>Delete Account</h2>

            <form action="/user/deleteAccount" method="post">
                {{ csrf_field() }}

                <input type="password" name="password" id="password" placeholder="Enter password"><br><br>

                <input type="submit" value="Delete Account">
            </form><hr>

            <a href="/logout" class="btn btn-danger mt-4">Logout</a>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
</body>
</html>
