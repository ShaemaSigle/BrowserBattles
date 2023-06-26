<!DOCTYPE html>
<html>
  <head>
    <title>My Game</title>
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/dogs.css') !!}" rel="stylesheet">


    <style>
.profile-container {
  width: fit-content;
  height: fit-content;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135, 0.8);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.profile-form input[type="email"],
.profile-form input[type="name"],
.profile-form input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #DDDDDD;
  border-radius: 4px;
  margin-bottom: 10px;
}
.profile-form{
    width:24vw;
}
.profile-form button, .deletion {
  background-color: #FFC0CB;
  border: none;
  color: #000000;
  padding: 12px 20px;
  border-radius: 4px;
  width: 100%;
  cursor: pointer;
  font-size: 16px;
}

.profile-form button:hover, .deletion:hover {
  background-color: #FFB6C1;
}
.btn, .deletion{
    width: auto;
}
.character{
    text-align: left;
    color: black;
}
.play_as{
    height: 4vh;
    padding: 0px 5px 0px 5px;
    margin-right: 5px;
}
.blankit{
    border: none;
    background:none;
    padding: 0;
    float: left;
    position: relative;
}
</style>
</head>

<body>
<?php use App\Models\Character;?>
@include('layouts.partials.navbar')
 <h1>@auth <?php $user = Auth::user(); ?> Let's play, {{$user->username}}!</h1>
  <div class="profile-container">
    <h2>Game</h2>
    
    @if ($user->active_character_id == NULL && !isset($character))
 <p class='error'>You don't have a character selected! Select a character (or create a new one) in order to play. You can do it in your profile.</p>
 @else
 <ul>
 <h3 style="padding-left: 0;">Your character:</h3>
 {{ $character->name }} - {{ $character->level }} LVL
 <br>
 Strength: {{ $character->strength }}
 <br>


 <form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'store']) }}>
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('post')
    <button type="submit" class="btn btn-outline-light li-right play_as">Get into a random encounter</button>
 </form>


  @endif
@endauth
</div>
</body>
</html>