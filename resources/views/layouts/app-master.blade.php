<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Home') }}</title>
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
    <script>
window.addEventListener('scroll', function() {
  var distanceScrolled = window.pageYOffset || document.documentElement.scrollTop;
  var banner = document.querySelector('.banner');
  banner.style.filter = 'blur(' + distanceScrolled / 60 + 'px)';
});
</script>

<?php  use Illuminate\Support\Facades\Session; ?>
 <?php $loc = Session::get("locale"); ?>
</head>
<body>


<h1 align="center">{{ __('Welcome to Browser Battles!') }}</h1>
    <div id="page-container">
        <div class="banner" style="background-image: url('{{ asset('assets/img/banner.jpg')}}');"> 
            <div class="banner-quote" >
                <figure>
                <blockquote class="blockquote">
                    <p>{{ __("Are you up for the challenge? It's time to prove your worth!") }}</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Chat GPT
                </figcaption>
                </figure>
            </div>
        </div>  
    </div>
    @include('layouts.partials.navbar')


<section class="content">
    <h1>{{ __('Join the battle and become a champion!') }}</h1>
<article class="main-container section">

<p>{{ __('Prepare yourself for an epic adventure filled with thrilling battles against powerful enemies.') }}</p>
<p>{{ __('Face formidable foes, engage in strategic battles, and rise to the top of the leaderboards.') }}</p>
    <p>{{ __("With every victory, you'll earn fame, glory, and valuable rewards.") }}</p>
    <p>{{ __('Join a community of brave warriors, form alliances, join guilds and conquer together.') }}</p>
    <p>{{ __('Embark on a quest that will push your limits, challenge your wit, and reward your bravery.') }}</p>
    <p>{{ __('Explore vast lands, uncover hidden treasures, and test your skills in combat.') }}</p>
    <p>{{ __('Will you emerge as a legendary hero or succumb to the challenges that await you?') }}</p>
    <p>{{ __('Get ready to embark on an unforgettable journey where every encounter brings new excitement and surprises.') }}</p>
    <p>{{ __('The path to greatness awaits. Will you seize the opportunity?') }}</p>


</article>

<div id="copyright">Copyright 2023 - All rights reserved</div>
</section>
</body>

@auth 
<?php $user=Auth::user(); ?>
@if($user->role=='admin')
@include('layouts.partials.adminNavbar')
@endif
@endauth
</html>