<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .gradient-custom {
        /* fallback for old browsers */
        background: #6a11cb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
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

    {{-- <form action="/register" method="post">
        {{ csrf_field() }}

        <input type="text" name="name" id="name" placeholder="name">
        <input type="email" name="email" id="email" placeholder="email">
        <input type="password" name="password" id="password" placeholder="password">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">

        <input type="submit" value="Register">
    </form> --}}


    <section class="vh-100 gradient-custom">
        <div class="container py-3 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                  <div class="mb-md-2 mt-md-1 pb-3">

                    <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                    <p class="text-white-50 mb-5">Please enter your data!</p>
                    <form action="/register" method="post">
                        {{ csrf_field() }}

                            <div class="form-outline form-white mb-4">
                                <input type="text" name="name" id="name" placeholder="name" class="form-control form-control-lg">
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="email" name="email" id="email" placeholder="email" class="form-control form-control-lg">
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" name="password" id="password" placeholder="password" class="form-control form-control-lg">
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation" class="form-control form-control-lg">
                            </div>
                            <input type="submit" value="Register" class="btn btn-outline-light btn-lg px-5">

                    </form>

                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                      <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                      <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                      <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                    </div>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

</body>
</html>
