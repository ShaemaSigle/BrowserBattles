<!DOCTYPE html>
<html>
  <head>
    <title>My Game</title>
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/dogs.css') !!}" rel="stylesheet">


    <style>
.profile-container {
  width: 100%;
  width: 80vw;
  height: 80vh;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135, 0.8);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
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
    float: left;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>
<?php use App\Models\Character; use App\Models\User; use App\Models\Enemy;?>
 <h1>@auth <?php $user = Auth::user(); ?> Let's play, {{$user->username}}!</h1>
 <?php 
  $character = Character::findOrFail($user->active_character_id); 
  if(!isset($enemy)) {
    $enemy = Enemy::findOrFail($encounter->enemy_id);
    $enemy_icon = $enemy->icon_name;
  }
  else{
    $enemy_icon = User::findOrFail($enemy->user_id)->profpic_path;
    if($enemy_icon == NULL) $enemy_icon = 'default_knight.png';
  }
    if($user->profpic_path != NULL) $image =  $user->profpic_path;
    else $image = 'default_knight.png';
 ?> 
  <div class="profile-container">
    <h2 style="text-align: center;">Encounter</h2>

  <div style="text-align: center;">You are facing a terrible {{$enemy->name}}!</div>
    @if ($user->active_character_id == NULL)
 <p class='error'>You don't have a characters selected! Select a character (or create a new one) in order to play. You can do it in your profile.</p>
 @else
Enemy: {{$enemy->name}}
<br>
<img src="{{asset('assets/img/'.$enemy_icon)}}" alt="" height="200px" width="200px">
<br>
Strength: {{$enemy->strength}}

<div style="float: right; margin-top: -27vh; text-align:right;"> 
You:{{$character->name}}<br>
  <img src="{{asset('assets/img/'.$image)}}" alt="" height="200px" width="200px">
  <br>
  Your strength: {{$character->strength}}
</div>
<br>
@isset($encounter)
@if($encounter->result==NULL)
<div style="margin-left: 45%;">
<form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'update'], [ 'encounter' => $encounter])}}>
    <input type="hidden" name="encounter" id="encounter" value="{{ $encounter->id }}">
    <input type="hidden" name="result" id="result" value="userLost">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">Escape</button>
 </form>
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'update'], [ 'encounter' => $encounter])}}>
    <input type="hidden" name="encounter" id="encounter" value="{{ $encounter->id }}">
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">Fight</button>
 </form>
<br><br>
</div>


@elseif($encounter->result == "userWon") You won! The encounter has ended.
@elseif($encounter->result == "userLost") You lost! The encounter has ended.
@endif
@endisset

 <br>
You can leave after the fight ends or before that, in which case the fight will be postponed.
<a href="{{action([App\Http\Controllers\CharacterController::class, 'show'], ['id'=>$character])}}" class="btn btn-outline-light li-right play_as">Leave</a>

@endif
@endauth
</div>
</body>
</html>