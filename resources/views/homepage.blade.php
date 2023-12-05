<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/user/home">
                <i class="fa fa-home"></i>
                <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/profile">
                <i class="fa fa-user">
                  <span class="badge badge-danger"></span>
                </i>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/question/notifications">
                  <i class="fa fa-bell">
                      <span class="badge badge-danger">{{ $unreadCount }}</span>
                  </i>
                </a>
              </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="/question/create">
                    <button type="button" class="btn btn-outline-success btn-sm">Create Post</button>
                </a>
            </li>
          </ul>


            <form action="/search" method="get" class="form-inline my-2 my-lg-0 mr-3">
                <input type="text" name="search" id="search" placeholder="Search questions" class="form-control mr-sm-2" style="margin-right: 40px;">

                <input type="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0">
            </form>

            <a href="/logout" class="btn btn-danger form-inline my-2 my-lg-0">Logout</a>
        </div>
      </nav>



    {{-- ===================================================================================== --}}



    {{-- ========================= MOST UPVOTE START =========================================================== --}}
    <div class="core">
        <div id="myBtnContainer">
            <button class="btn_filter active" onclick="filterSelection('upvotedQuestions')"> Most Upvoted Questions</button>
            <button class="btn_filter" onclick="filterSelection('activeQuestions')"> Most Active Questions</button>
            <button class="btn_filter" onclick="filterSelection('newestQuestions')"> Newest Questions</button>
            <button class="btn_filter" onclick="filterSelection('upvotedUsers')"> Most Upvoted Users</button>
            <button class="btn_filter" onclick="filterSelection('activeUsers')"> Most Active Users</button>
            <button class="btn_filter" onclick="filterSelection('newestUsers')"> Newest Users</button>
        </div>


        <div class="container">
            <div class="filterDiv upvotedQuestions">
                <hr>
                <h2>Most Upvoted Questions of All Time</h2>
                <hr>

                @foreach ($mostUpvotedQuestions as $key => $question)

                <div class="card mb-4">
                    <div class="card-body text">
                        {{-- ======================================================================= --}}
                                <div  style="display: flex; align-items: center;">

                                    @if (!empty($question->user->image_url) && $question->user->image_url !== '')

                                        <a class="nav-link disabled" href="/user/profile/{{ $question->user->id }}">
                                            <img src="/storage/uploads/{{ $question->user->image_url }}" alt="Profile Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; margin-right: 10px" >
                                        </a>

                                    @else
                                        {{-- Gunakan foto default jika foto profil tidak ada --}}
                                        <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; margin-right: 10px"><br><br>
                                    @endif


                                    <div>
                                        <a href="/user/profile/{{ $question->user->id }}">
                                            <h4 style="text-transform: capitalize; margin-bottom: 0; font-size: 20px; color: black;">{{ $question->user->name }}</h4>
                                        </a>

                                        @if ($question->user != null)
                                            <h7 style="font-size: 14px; font-weight: normal;">Wrote on {{ $question->created_at->format('d M y . H:i') }}</h7><br>
                                        @else
                                            <h4>Posted on {{ $question->created_at }}-[Deleted User]</h4>
                                        @endif
                                    </div>
                                </div>
                                <hr style="2px solid">

                                <a href="/question/view/{{ $question->id }}">
                                    <h3 style="color: black;">{{ $question->title }}</h3>
                                    @if ($question->replies->count() > 0)
                                        <p style="color: black;">{{ $question->replies->first()->body }}</p>
                                    @else
                                        continue;
                                    @endif
                                </a>

                                <div>
                                    <h5>{{ $question->upvotes }} upvotes | {{ $question->replies->count() }} replies</h5>
                                    <br>
                                </div>

                        {{-- ======================================================================= --}}
                    </div>
                </div>
                @endforeach

            </div>

            <div class="filterDiv activeQuestions">
                <hr>
                <h2>Most Active Questions in the Last 24 Hours</h2>
                <hr>

                @foreach ($mostActiveQuestions as $value)
                    <div class="card mb-4">
                        <div class="card-body text">

                            {{-- ================================================ --}}

                            <div  style="display: flex; align-items: center;">

                                @if (!empty($value[0]->user->image_url) && $value[0]->user->image_url !== '')

                                    <a class="nav-link disabled" href="/user/profile/{{ $value[0]->user->id }}">
                                        <img src="/storage/uploads/{{ $value[0]->user->image_url }}" alt="Profile Image" style="max-width: 60px; border-radius: 50%; margin-right: 10px" >
                                    </a>

                                @else
                                    {{-- Gunakan foto default jika foto profil tidak ada --}}
                                    <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 70px; border-radius: 50%; margin-right: 10px"><br><br>
                                @endif


                                <div>
                                    <a href="/user/profile/{{ $value[0]->user->id }}">
                                        <h4 style="text-transform: capitalize; margin-bottom: 0; font-size: 20px; color: black;">{{ $value[0]->user->name }}</h4>
                                    </a>

                                    @if ($value[0]->user != null)
                                        <h7 style="font-size: 14px; font-weight: normal;">Wrote on {{ $value[0]->created_at->format('d M y . H:i') }}</h7><br>
                                    @else
                                        <h4>Posted on {{ $value[0]->created_at }}-[Deleted User]</h4>
                                    @endif
                                </div>
                            </div>
                            <hr style="2px solid">

                            <a href="/question/view/{{ $value[0]->id }}">
                                <h3 style="color: black;">{{ $value[0]->title }}</h3>
                                @if ($question->replies->count() > 0)
                                    <p style="color: black;">{{ $value[0]->replies->first()->body }}</p>
                                @else
                                    continue;
                                @endif
                            </a>

                            <div>
                                <h5>{{ $value[0]->upvotes }} upvotes | {{ $value[0]->replies->count() }} replies</h5>
                                <br>
                            </div>

                            {{-- ================================================ --}}
                            {{-- <a href="/question/view/{{ $value[0]->id }}">
                                <h3>{{ $value[0]->title }}</h3>
                                @if ($question->replies->count() > 0)
                                    <p>{{ $value[0]->replies->first()->body }}</p>
                                @else
                                    continue;
                                @endif
                            </a>

                            <h5>Asked byyy <a href="/user/profile/{{ $value[0]->user->id }}">{{ $value[0]->user->name }}</a> | {{ $value[0]->upvotes }} upvotes | {{ count($value) }} new replies</h5> --}}
    {{--
                            <br> --}}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="filterDiv newestQuestions">
                <hr>
                <h2>Newest Questions</h2>
                <hr>

                @foreach ($newestQuestions as $key => $value)
                    <div class="card mb-4">
                        <div class="card-body text">
                            {{-- ===================================================== --}}

                            <div  style="display: flex; align-items: center;">

                                @if (!empty($value->user->image_url) && $value->user->image_url !== '')

                                    <a class="nav-link disabled" href="/user/profile/{{ $value->user->id }}">
                                        <img src="/storage/uploads/{{ $value->user->image_url }}" alt="Profile Image" style="max-width: 60px; border-radius: 50%; margin-right: 10px" >
                                    </a>

                                @else
                                    {{-- Gunakan foto default jika foto profil tidak ada --}}
                                    <img src="/storage/defaults/default-profile.jpg" alt="Default Image" style="max-width: 70px; border-radius: 50%; margin-right: 10px"><br><br>
                                @endif


                                <div>
                                    <a href="/user/profile/{{ $value->user->id }}">
                                        <h4 style="text-transform: capitalize; margin-bottom: 0; font-size: 20px; color: black;">{{ $value->user->name }}</h4>
                                    </a>

                                    @if ($value->user != null)
                                        <h7 style="font-size: 14px; font-weight: normal;">Wrote on {{ $value->created_at->format('d M y . H:i') }}</h7><br>
                                    @else
                                        <h4>Posted on {{ $value->created_at }}-[Deleted User]</h4>
                                    @endif
                                </div>
                            </div>
                            <hr style="2px solid">

                            <a href="/question/view/{{ $value->id }}">
                                <h3 style="color: black;">{{ $value->title }}</h3>
                                @if ($question->replies->count() > 0)
                                    <p style="color: black;">{{ $value->replies->first()->body }}</p>
                                @else
                                    continue;
                                @endif
                            </a>

                            <div>
                                <h5>{{ $value->upvotes }} upvotes | {{ $value->replies->count() }} replies</h5>
                                <br>
                            </div>

                            {{-- ===================================================== --}}
                            {{-- <a href="/question/view/{{ $value->id }}">
                                <h3>{{ $value->title }}</h3>
                                @if ($question->replies->count() > 0)
                                    <p>{{ $value->replies->first()->body }}</p>
                                @else
                                    continue;
                                @endif
                            </a>

                            <h5>Asked by <a href="/user/profile/{{ $value->user->id }}">{{ $value->user->name }}</a> | {{ $value->upvotes }} upvotes | {{ $value->replies->count() }} replies</h5>

                            <br> --}}
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="filterDiv upvotedUsers">
                <hr>
                <h2>Most Upvoted Users in the Last 24 Hours</h2>
                <hr>

                @foreach ($mostUpvotedUsers as $item)
                    <div class="card mb-4">
                        <div class="card-body text">
                            <a href="/user/profile/{{ $item[0]->id }}">
                                <h3>{{ $item[0]->name }}</h3>
                            </a>

                            <p>{{ count($item) }} new upvotes</p>

                            <br>
                        </div>
                    </div>


                @endforeach
            </div>

            <div class="filterDiv activeUsers">
                <hr>
                <h2>Most Active Users in the Last 24 Hours</h2>
                <hr>

                @foreach ($mostActiveUsers as $item)
                    <div class="card mb-4">
                        <div class="card-body text">
                            <a href="/user/profile/{{ $item[0]->id }}">
                                <h3>{{ $item[0]->name }}</h3>
                            </a>

                            <p>{{ count($item) }} new replies posted</p>

                            <br>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="filterDiv newestUsers">
                <hr>
                <h2>Newest Users in the Last 24 Hours</h2>
                <hr>

                @foreach ($newestUsers as $key => $value)
                    <div class="card mb-4">
                        <div class="card-body text">
                            <a href="/user/profile/{{ $value->id }}">
                                <h3>{{ $value->name }}</h3>
                            </a>

                            <p>Joined on {{ $value->created_at }}</p>

                            <br>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    </div>



    <script>
        // Tanggal dan waktu dari PHP Blade
        var dateTimeString = "{{ $question->created_at }}";
        var dateTime = new Date(dateTimeString);

        // Mengonversi format tanggal
        var optionsDate = { day: '2-digit', month: 'short', year: '2-digit' };
        var formattedDate = dateTime.toLocaleDateString('en-US', optionsDate); // '28 Nov 23'

        // Menyusun hasil
        var result = formattedDate;

        // Menampilkan default page home pada class upvotedQuestions
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan kelas 'show' pada elemen dengan class 'upvotedQuestions'
            const defaultFilterDiv = document.querySelector('.filterDiv.upvotedQuestions');
            defaultFilterDiv.classList.add('show');

            // Tambahkan kelas 'active' pada tombol dengan filterName 'upvotedQuestions'
            const defaultButton = document.querySelector('.btn_filter[onclick="filterSelection(\'upvotedQuestions\')"]');
            defaultButton.classList.add('active');
        });

        function filterSelection(filterName) {
  // Get all filterDiv elements
        const filterDivs = document.querySelectorAll('.filterDiv');

        // Hide all filterDiv elements
        for (const filterDiv of filterDivs) {
            filterDiv.classList.remove('show');
        }

        // Show the filterDiv element with the specified filterName
        const targetFilterDiv = document.querySelector('.filterDiv.' + filterName);
        targetFilterDiv.classList.add('show');

        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.btn_filter');
        for (const button of buttons) {
            button.classList.remove('active');
        }

        // Add active class to the selected button
        const selectedButton = document.querySelector('.btn_filter[onclick="filterSelection(\'' + filterName + '\')"]');
        selectedButton.classList.add('active');
        }



        // Menampilkan hasil di console atau di HTML sesuai kebutuhan Anda
        // console.log(result);

    </script>

</body>
</html>
