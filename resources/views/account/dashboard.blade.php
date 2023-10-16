@extends('base')

@section('title', 'User Login')

@section('main-content')

<h1>Dashboard</h1>

<a href="/account/edit">Edit Account</a>

<form action="/account/logout" method="post">
    {{ csrf_field() }}

    <input type="submit" value="Logout">
</form>

@endsection