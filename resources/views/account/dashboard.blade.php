@extends('base')

@section('title', 'User Login')

@section('main-content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Agbalumo">

    <style>
        p {
            font-family: 'Agbalumo', sans-serif;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/about/parento">Parento</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/account/dashboard">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Following</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/account/login">Action</a></li>
                  <li><a class="dropdown-item" href="/account/register">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

    <p style="margin: auto 5% 2%">Hi {{ Auth::user()->username }}</p>
    <form action="/account/logout" method="post">
        {{ csrf_field() }}

        <input type="submit" value="Logout">
    </form>

    <a href="/account/edit">Edit Account</a>

    {{-- <div style="width: 960px; margin: 0 auto; padding-top: 80px; padding-bottom: 80px;">

        <h1>Full-Width, Left-Aligned</h1>
        <div class="testimonial-quote group">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <blockquote>
                    <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                </blockquote>
                <cite><span>Kristi Bruno</span><br>
                    Social Media Specialist<br>
                    American College of Chest Physicians
                </cite>
            </div>
        </div>
        <div class="testimonial-quote group">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <blockquote>
                    <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                </blockquote>
                <cite><span>Kristi Bruno</span><br>
                    Social Media Specialist<br>
                    American College of Chest Physicians
                </cite>
            </div>
        </div>
        <div class="testimonial-quote group">
            <img src="http://placehold.it">
            <div class="quote-container">
                <blockquote>
                    <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                </blockquote>
                <cite><span>Kristi Bruno</span><br>
                    Social Media Specialist<br>
                    American College of Chest Physicians
                </cite>
            </div>
        </div>
        <div class="testimonial-quote group">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <blockquote>
                    <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                </blockquote>
                <cite><span>Kristi Bruno</span><br>
                    Social Media Specialist<br>
                    American College of Chest Physicians
                </cite>
            </div>
        </div> --}}

        {{-- <hr style="margin: 60px auto; opacity: .5;">

        <h1>Full-Width, Right-Aligned</h1>
        <div class="testimonial-quote group right">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <div>
                    <blockquote>
                        <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                    </blockquote>
                    <cite><span>Kristi Bruno</span><br>
                        Social Media Specialist<br>
                        American College of Chest Physicians
                    </cite>
                </div>
            </div>
        </div> --}}

        {{-- <hr style="margin: 60px auto; opacity: .5;">

        <h1>600px-Wide, Right-Aligned</h1>
        <div class="testimonial-quote group right" style="width: 600px; margin-right: auto;">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <div>
                    <blockquote>
                        <p>Overall, fantastic! I'd recommend them to anyone looking for a creative, thoughtful, and professional team.”</p>
                    </blockquote>
                    <cite><span>Kristi Bruno</span><br>
                        Social Media Specialist<br>
                        American College of Chest Physicians
                    </cite>
                </div>
            </div>
        </div>

        <hr style="margin: 60px auto; opacity: .5;">

        <h1>600px Wide, Right-Aligned</h1>
        <div class="testimonial-quote group " style="width: 600px; margin-left: auto;">
            <img src="http://placehold.it/120x120">
            <div class="quote-container">
                <blockquote>
                    <p>Overall, fantastic! I'd recommend them to anyone looking for a creative,<br> thoughtful, and professional team.”</p>
                </blockquote>
                <cite><span>Kristi Bruno</span><br>
                    Social Media Specialist<br>
                    American College of Chest Physicians
                </cite>
            </div>
        </div> --}}

    </div>
</body>
</html>


@endsection
