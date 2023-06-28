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
  margin-left: 32%;
}
</style>
</head>

<body>
<?php use App\Models\Character; use App\Models\User; use App\Models\Enemy; use Illuminate\Support\Facades\Session; ?>
 <h1><?php $user = Auth::user(); $loc = Session::get("locale"); ?> {{ __("Let's play, ") }}{{$user->username}}!</h1>
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
  {{ __("Strength") }}:<b id="charStrength"> {{$character->strength}}</b><br>
  {{ __("Health") }}: <b id="healthPlayer"></b>
</div>
<br>
@endif

<div style="margin-left: 45%;" id="escape">
@isset($encounter)
<form method="POST" class="blankit" action={{action([App\Http\Controllers\EncounterController::class, 'update'], [ 'encounter' => $encounter])}}>
    <input type="hidden" name="encounter" id="encounter" value="{{ $encounter->id }}">
    <input type="hidden" name="result" id="result" value="userLost">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">{{ __("Escape") }}</button>
 </form>
 @endisset
 <button class="btn btn-outline-light li-right play_as" id="ATTAC">{{ __("Attack") }}</button>
<br><br>
</div>

<div id="resultWon">{{ __("You won! The encounter has ended.") }}<br>
@isset($encounter) {{ __("Strength") }}: +{{$enemy->strength}}!@endisset</div>
<div id="resultLost">{{ __("You lost! The encounter has ended.") }}</div>


 <br>
 {{ __("You can leave after the fight ends or before that, in which case the fight will be postponed.") }}
<a href="{{action([App\Http\Controllers\CharacterController::class, 'show'], ['id'=>$character])}}" class="btn btn-outline-light li-right play_as">{{ __("Leave") }}</a>

</div>
</body>
</html>
<script>

$(document).ready(function(){
  var attckButton = document.getElementById("ATTAC");
  var resultL = document.getElementById("resultLost");
  var resultW = document.getElementById("resultWon");
  var escBtn = document.getElementById("escape");

  // PHP variables
var LVL = <?php echo $character->level; ?>;
var strengthEnemy = <?php echo $enemy->strength; ?>;
var strengthPlayer = <?php echo $character->strength; ?>;
var enemyName = "<?php echo $enemy->name; ?>";
var locale = "<?php echo $loc; ?>";

// Calculate variables using the formulas
var healthEnemy = 100 + strengthEnemy / 100;
var healthPlayer = 100 + strengthPlayer / 100 + 25*LVL;
var atkEnemy = Math.floor(10 + strengthEnemy / 100);
var atkPlayer = Math.floor(LVL * 10 + strengthPlayer / 100);
var oddsP = strengthPlayer / strengthEnemy;
var oddsE = strengthEnemy / strengthPlayer;


if(locale == 'ru') {
  var hitE = enemyName + " ударил вас!";
  var hitP = "Вы ударили врага!";
  var missE = enemyName + " промахнулся!";
  var missP = "Вы промахнулись!";
  var lvlup = "Уровень повышен!";
}
else if(locale == 'lv'){
  var hitE = enemyName + " trāpīja!";
  var hitP = "Jūs trāpījāt!";
  var missE = enemyName + " netrāpīja!";
  var missP = "Jūs netrāpījāt!";
  var lvlup = "Līmenis paaugstināts!";
} 
else{
  var hitE = enemyName + " hit you!";
  var hitP = "You hit your enemy!";
  var missE = enemyName + " missed!";
  var missP = "You missed!";
  var lvlup = "Level up!";
}

$('#healthEnemy').text(Math.floor(healthEnemy));
$('#healthPlayer').text(Math.floor(healthPlayer));
    
  if(attckButton != null){
      attckButton.addEventListener("click", function() {
        var realOdds = Math.floor(Math.random() * (oddsP+4));
        if(realOdds>oddsP) $("#Battle").append("<br>", missP);// console.log("Odds: ", oddsP, " vs ", realOdds);}
        else if(realOdds<=oddsP){
          //console.log("Odds: ", oddsP, " vs ", realOdds);
          $("#Battle").append("<br>", hitP, "<b> -"+atkPlayer+"HP</b>");
          healthEnemy = healthEnemy-atkPlayer;
          healthEnemy = Math.floor(healthEnemy);
          if(healthEnemy<0) healthEnemy = 0;
          $('#healthEnemy').text(healthEnemy);
        } 
        if(healthEnemy <= 0){
          <?php 
              if(isset($encounter))  { 
                echo " var enco = $encounter->id;  
                update_encounter_data('player', enco); "; 
              }
              else{
                echo "update_duel_data('player')";
              } 
            ?>            
            attckButton.style.display = "none";
            escBtn.style.display = "none";   
            resultW.style.display = "block";       
        } 
        else{
          var realOdds = Math.floor(Math.random() * (oddsE+4));
          if(realOdds>oddsE) $("#Battle").append("<br>", missE);// console.log("Enemy odds: ", oddsE, " vs ", realOdds);}
          else if(realOdds<=oddsE){
            //console.log("Enemy odds: ", oddsE, " vs ", realOdds);
            $("#Battle").append("<br>", hitE, "<b> -"+atkEnemy+"HP</b>");
            healthPlayer = healthPlayer-atkEnemy;
            healthPlayer = Math.floor(healthPlayer)
            if(healthPlayer<0) healthPlayer = 0;
            $('#healthPlayer').text(healthPlayer);
          } 
          if(healthPlayer <= 0){
            <?php 
              if(isset($encounter))  {
                echo "var enco = $encounter->id;  
                update_encounter_data('enemy', enco); ";
              } 
            ?>  
            attckButton.style.display = "none";
            escBtn.style.display = "none";
            resultL.style.display = "block";
          } 
        }
      });
    } 
    <?php 
    if(isset($encounter))  {
      $rout = route('encounter_update.action', $encounter->id);
      echo " function update_encounter_data(winner, encounter){
        console.log('goind with ', winner, encounter)
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
            },
            url:\"$rout\",
            method:'POST',
            data:{winner:winner, encounter:encounter},
            dataType:'json',
              success:function(data){
                newLVL = data.newLVL;
                if(newLVL == 'true')$(\"#resultWon\").append(\"<br>\", lvlup);
                else console.log(newLVL);
              }
            })
        }
      
      ";
    }
    else
    $rout = route('duel_update.action');
      echo " 
      function update_duel_data(winner){ 
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
            },
            url:\"$rout\",
            method:'POST',
            data:{winner:winner},
            dataType:'json',
            })
        }
      "; 
    ?> 
});

</script>