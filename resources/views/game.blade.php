<!DOCTYPE html>
<html>
  <head>
    <title>{{ __('Game') }}</title>
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
 <h1>@auth <?php $user = Auth::user(); ?>{{ __("Let's play, ") }} {{$user->username}}!</h1>
  <div class="profile-container">
    <h2>{{ __('Game') }}</h2>
    
    @if ($user->active_character_id == NULL && !isset($character))
 <p class='error'>{{ __("You don't have a character selected! Select a character (or create a new one) in order to play. You can do it in your profile.") }}</p>
 @else
 <ul>
 <h3 style="padding-left: 0;">{{ __('Your Character') }}:</h3>
 {{ $character->name }} - {{ $character->level }} LVL
 <br>
 {{ __('Strength') }}: {{ $character->strength }}
 <br>


 @if($user->active_character_id == $character->id)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'store']) }}>
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('post')
    <button type="submit" class="btn btn-outline-light li-right play_as">{{ __('Find a random enemy') }}</button>
 </form>
 @elseif($user->role == 'admin')
 <form method="POST" class="blankit" action="{{action([App\Http\Controllers\CharacterController::class, 'destroy'],  $character->id) }}">
    @csrf
    @method('DELETE')
    <button class="btn btn-outline-light li-right play_as" style="background-color: red;" type="submit" value="delete" onclick="return confirm('{{ addslashes(__('Delete character?')) }}')">{{ __('Delete') }}</button>
  </form>
@endif

  @endif
@endauth
</div>
</body>
</html>