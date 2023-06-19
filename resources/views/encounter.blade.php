<!DOCTYPE html>
<html>
  <head>
    <title>My Game</title>
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/dogs.css') !!}" rel="stylesheet">


    <style>
.profile-container {
  width: 100%;
  height: 100vh;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135, 0.8);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
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
 <h1>@auth <?php $user = Auth::user(); ?> Let's play, {{$user->username}}!</h1>
  <div class="profile-container">
    <h2>Encounter</h2>
    
    @if ($user->active_character_id == NULL)
 <p class='error'>You don't have a characters selected! Select a character (or create a new one) in order to play. You can do it in your profile.</p>
 @else
 <ul>
<?php $character = Character::where('id', '=', $user->active_character_id)->first();?>
Well you are dead now mb 
@endif
@endauth
</div>
</body>
</html>