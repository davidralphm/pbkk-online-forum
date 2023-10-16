@extends('base')

@section('title', 'User Login')

@section('main-content')

<form action="/account/login" method="post">
    {{ csrf_field() }}

    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}">
    </div>
    
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="{{ old('password') }}">
    </div>
    
    <input type="submit" value="Login">
</form>

@endsection