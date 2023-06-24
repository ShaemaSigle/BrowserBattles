<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Guild view</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
.profile-container {
    width: 80vw;
  height: 80vh;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135, 0.8);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}
.flying{
    margin-top: -40%;
    margin-right: 15%;
    float: right;
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
.table-responsive{
    overflow-y: scroll;
    height: 50vh;
    width: 40vw;
}
.subdescr{
    float: right;
    margin-top: -30%;
    margin-right: 15%;
}
.descr{
    background-color: rgb(201, 168, 125, 0.8);
    height: 200px;
    width: 300px;
    border-style:solid;
    border-width: 1px;
    border-radius: 10px;
    border-color: rgb(232, 229, 220);
    padding: 10px;
}
</style>
</head>
<body>

@include('layouts.partials.navbar')
<?php
use App\Models\Guild;
use App\Models\Character;
use App\Http\Controllers\GuildController;
 $user = Auth::user(); 
 $owner = Character::findOrFail($guild->owner);
?>
<h1>Guild view</h1>
 <div class="profile-container">
 
 <div class="container-box">
    <h3 style="padding: 0; margin: 0;">List of members</h3>
   <div class="panel panel-default" style="width: 40vw;">
    <div class="panel-heading">Seek players</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Begin inputting the name of the guild..." />
     </div>
     <div class="table-responsive">
      <!-- <h3 align="center">Total Data : <span id="total_records"></span></h3> -->
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>Name</th>
         <th>Strength</th>
         <th>Level</th>
         <th>DuelsWon</th>
        </tr>
       </thead>
       <tbody>
       </tbody>
      </table>
     </div>
    </div>    
   </div>

<div class="subdescr">
    Description
   <div class="descr">
    {{$guild->description}}
   </div>
   Owner: {{$owner->name}}
</div>


  @can('destroy', $guild)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'destroy'], [ 'guild' => $guild->id]) }}>
    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('Are you sure you wish to delete this account?')">Delete guild</button>
 </form>
 @endcan
 <h1 class="flying">{{$guild->name}}</h1>

 @auth
 @if($user->active_character_id)

@can('leave-guild', $guild)
 <form method="PosT" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'leave'], ['id' => $guild->id]) }}>
    @csrf
    @method('PuT')
    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('Are you sure you wish to leave this guild?')">Leave guild</button>
 </form>
@endcan

@can('join-guild')
 <form method="PosT" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'join'], ['id' => $guild->id]) }}>
    @csrf
    @method('PuT')
    <button type="submit" class="btn btn-outline-light li-right play_as"> Join guild </button>
 </form>
 @endcan

 @endif
 @endauth
</div>

</body>
@auth 
@if($user->role=='admin')
@include('layouts.partials.adminNavbar')
@endif
@endauth
</html>
<script>
$(document).ready(function(){
 fetch_character_data();
 function fetch_character_data(query = ''){
  $.ajax({
   url:"{{ route('list_members.action', $guild->id) }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data){
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_character_data(query);
 });
});
</script>