<!DOCTYPE html>
<html>
  <head>
    <title>My Game</title>
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/dogs.css') !!}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
#Battle{
  position: absolute;
  margin-left: 32%;
  overflow-y: scroll;
    height: 35vh;
}
 #resultLost, #resultWon{
  display: none;
}
</style>
</head>

<body>
<?php use App\Models\Character; use App\Models\User; use App\Models\Enemy;?>
 <h1>@auth <?php $user = Auth::user(); ?> {{ __("Let's play, ") }}{{$user->username}}!</h1>
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
    <h2 style="text-align: center;">{{ __("Encounter") }}</h2>

  <div style="text-align: center;" id="Battle">{{ __("You are facing a terrible") }} {{$enemy->name}}!</div>
    @if ($user->active_character_id == NULL)
 <p class='error'>{{ __("You don't have a character selected! Select a character (or create a new one) in order to play. You can do it in your profile.") }}</p>
 @else
 {{ __("Enemy") }}: {{$enemy->name}}
<br>
<img src="{{asset('assets/img/'.$enemy_icon)}}" alt="" height="200px" width="200px">
<br>
{{ __("Strength") }}: {{$enemy->strength}}
<br>
{{ __("Health") }}: <b id="healthEnemy"></b>

<div style="float: right; margin-top: -27vh; text-align:right;"> 
{{$character->name}}<br>
  <img src="{{asset('assets/img/'.$image)}}" alt="" height="200px" width="200px">
  <br>
  {{ __("Strength") }}: {{$character->strength}}<br>
  {{ __("Health") }}: <b id="healthPlayer"></b>
</div>
<br>
@endif
@isset($encounter)
@if($encounter->result==NULL)
<div style="margin-left: 45%;">
<form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'update'], [ 'encounter' => $encounter])}}>
    <input type="hidden" name="encounter" id="encounter" value="{{ $encounter->id }}">
    <input type="hidden" name="result" id="result" value="userLost">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">{{ __("Escape") }}</button>
 </form>
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'update'], [ 'encounter' => $encounter])}}>
    <input type="hidden" name="encounter" id="encounter" value="{{ $encounter->id }}">
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">{{ __("Fight") }}</button>
 </form>
 <button id="ATTAC">Attac</button>
<br><br>
</div>

<div id="resultWon">{{ __("You won! The encounter has ended.") }}</div>
<div id="resultLost">{{ __("You lost! The encounter has ended.") }}</div>

@endisset

 <br>
 {{ __("You can leave after the fight ends or before that, in which case the fight will be postponed.") }}
<a href="{{action([App\Http\Controllers\CharacterController::class, 'show'], ['id'=>$character])}}" class="btn btn-outline-light li-right play_as">{{ __("Leave") }}</a>

@endif
@endauth
</div>
</body>
</html>
<script>

$(document).ready(function(){
  var attckButton = document.getElementById("ATTAC");
  var resultL = document.getElementById("resultLost");
  var resultW = document.getElementById("resultWon");

  if(resultL != null) console.log('found');
  // Given variables
var LVL = <?php echo $character->level; ?>;
var strengthEnemy = <?php echo $enemy->strength; ?>;
var strengthPlayer = <?php echo $character->strength; ?>;
var enemyName = "<?php echo $enemy->name; ?>";

// Calculate health variables using the formulas
var healthEnemy = 100 + strengthEnemy / 100;
var healthPlayer = 100 + strengthPlayer / 100 + 25*LVL;
var atkEnemy = 10 + strengthEnemy / 100;
var atkPlayer = LVL * 10 + strengthPlayer / 100;
var oddsP = strengthPlayer / strengthEnemy;
var oddsE = strengthEnemy / strengthPlayer;

$('#healthEnemy').text(healthEnemy);
$('#healthPlayer').text(healthPlayer);
    
  if(attckButton != null){
      attckButton.addEventListener("click", function() {
        var realOdds = Math.floor(Math.random() * (oddsP+4));
        if(realOdds>oddsP) {$("#Battle").append("<br> You missed!"); console.log("Odds: ", oddsP, " vs ", realOdds);}
        else if(realOdds<=oddsP){
          console.log("Odds: ", oddsP, " vs ", realOdds);
          $("#Battle").append("<br> You hit your enemy!");
          healthEnemy = healthEnemy-atkPlayer;
          healthEnemy = Math.floor(healthEnemy);
          if(healthEnemy<0) healthEnemy = 0;
          $('#healthEnemy').text(healthEnemy);
        } 
        if(healthEnemy <= 0){
          var enco = <?php echo $encounter->id; ?>;
          attckButton.style.display = "none";
          update_encounter_data('player', enco);
        } 
        else{
          var realOdds = Math.floor(Math.random() * (oddsE+4));
          if(realOdds>oddsE) {$("#Battle").append("<br>", enemyName, " missed!"); console.log("Enemy odds: ", oddsE, " vs ", realOdds);}
          else if(realOdds<=oddsE){
            console.log("Enemy odds: ", oddsE, " vs ", realOdds);
            $("#Battle").append("<br>", enemyName, " hit you!");
            healthPlayer = healthPlayer-atkEnemy;
            healthPlayer = Math.floor(healthPlayer)
            if(healthPlayer<0) healthPlayer = 0;
            $('#healthPlayer').text(healthPlayer);
          } 
          if(healthPlayer <= 0){
            var enco = <?php echo $encounter->id; ?>;
            attckButton.style.display = "none";
            update_encounter_data('enemy', enco);
          } 
        }
      });
    } 

 function update_encounter_data(winner, encounter){
  console.log('goind with ', winner, encounter)
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
   url:"{{ route('encounter_update.action', $encounter->id) }}",
   method:'POST',
   data:{winner:winner, encounter:encounter},
   dataType:'json',
   success:function(data){
    console.log("sent");
    if(winner=='player') resultW.style.display = "block";
    else resultL.style.display = "block";
   }
  })
 }
});



</script>