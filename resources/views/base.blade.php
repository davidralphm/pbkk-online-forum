<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav>
            @yield('nav-content')
        </nav>

        @yield('header-content')
    </header>

    <div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <h3>{{ $error }}</h3>
            @endforeach
        @endif

        @if (Session::has('message-success'))
            <h3>{{ Session::get('message-success') }}</h3>
        @endif
    </div>

    <main>
        @yield('main-content')
    </main>

    <footer>
        @yield('footer-content')
    </footer>
</body>
</html>