@extends('base')

@section('title', 'User Registration')

@section('main-content')

<form action="/account/register" method="post">
    {{ csrf_field() }}

    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}">
    </div>
    
    <div>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
    </div>
    
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
    </div>
    
    <div>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>
    
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
    </div>
    
    <input type="submit" value="Register">
</form>

@endsection