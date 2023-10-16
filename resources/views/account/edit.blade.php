@extends('base')

@section('title', 'Edit Account')

@section('main-content')

<form action="/account/edit" method="post">
    {{ csrf_field() }}
    
    <div>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name"
            @if (old('first_name'))
                value="{{ old('first_name') }}"
            @else
                value="{{ $user->first_name }}"
            @endif
        >
    </div>
    
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name"
            @if (old('last_name'))
                value="{{ old('last_name') }}"
            @else
                value="{{ $user->last_name }}"
            @endif
        >
    </div>
    
    <div>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email"
            @if (old('email'))
                value="{{ old('email') }}"
            @else
                value="{{ $user->email }}"
            @endif
        >
    </div>
    
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div>
        <label for="signature">Signature</label>
        <textarea name="signature" id="signature" cols="30" rows="10"></textarea>
    </div>

    <div>
        <label for="image">Profile Image</label>
        <input type="file" name="image" id="image">
    </div>
    
    <input type="submit" value="Save Changes">
</form>

<script>
    const signature = document.getElementById('signature');

    @if (old('signature'))
        signature.innerText="{{ old('signature') }}";
    @else
        signature.innerText="{{ $user->signature }}";
    @endif
</script>

@endsection