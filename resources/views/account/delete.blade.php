@extends('base')

@section('title', 'Delete Account')

@section('main-content')

<h1>Are you sure you want to delete your account?</h1>

<form action="/account/delete" method="post">
    {{ csrf_field() }}
    
    <input type="submit" value="Delete Account">
</form>

@endsection