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
</head>
<body>

    <h1>Dashboard</h1>
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
