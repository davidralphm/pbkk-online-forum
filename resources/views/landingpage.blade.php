<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parento</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
</head>
<body>
          <!-- Start Landing Page -->
          <div class="landing-page">
            <header>
              <div class="container">
                <a href="/" class="logo" style="text-decoration: none;"><b>Parento</b></a>
                <ul class="links">
                  <li><a href="/register" class="btn btn-outline-info">Register</a></li>
                  <li><a href="/login" class="btn btn-outline-info">Login</a></li>
                </ul>
              </div>
            </header>

            <div class="content">
              <div class="container">
                <div class="info">
                  <h1>Online Parenting Forum for Asking and Sharing</h1>
                  <p>Together, we create a warm and inclusive environment for sharing the joys and challenges of parenthood.</p>
                  {{-- <a href="/login" class="btn btn-outline-primary" style="margin-top: 20px">Login</a> --}}
                </div>
                <div class="image">
                  <img src="/storage/defaults/family.jpg">
                </div>
              </div>
            </div>

          </div>
          <!-- End Landing Page -->
</body>
</html>
