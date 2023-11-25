<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
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

    <b>Name : {{ $user->name }}</b><br><hr>
    <b>Email : {{ $user->email }}</b><br><hr>
    <b>Role : {{ $user->role }}</b><br><hr>
    <b>About : {{ $user->about }}</b><br><hr>
    <b>Image URL : {{ $user->image_url }}</b><br><hr>

    @if ($user->userReport() == null)
        <a href="/user/report/{{ $user->id }}">Report</a>
    @else
        <a href="/user/removeReport/{{ $user->id }}">Remove Report</a>
    @endif

    @if (!empty($user->image_url) && $user->image_url !== '')
        <h3>Profile Image</h3>
        <img src="/storage/uploads/{{ $user->image_url }}" alt="Profile Image"><br><br>
    @endif
</body>
</html>
