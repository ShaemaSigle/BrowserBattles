<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>{{ __('Guild') }} </title>
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
    position: fixed;
    right: 550px;
    top: 300px;
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

    margin-right: -200px;
}
#flagging_forma {
      position: fixed;
      top: 54%;
      left: 66%;
      height: 27%;
      width: 20%;
      background-color: none;
      transform: translate(-50%, -50%);
      padding: 20px;
      border: none;
}
#input_field {
    margin-top: -10px;
    margin-left: -30px;
    height:150px;
    font-size:14pt;
}
i{
    position: fixed;
    right: 550px;
    top: 300px;
}
#name{
    position: fixed;
    right: 400px;
    top: 200px;
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
<h1>{{ __('Guild') }}</h1>
<h1 id="name">{{$guild->name}}</h1>
 <div class="profile-container">
 
 <div class="container-box">
    <h3 style="padding: 0; margin: 0;">{{ __('Members') }}</h3>
   <div class="panel panel-default" style="width: 40vw;">
    <div class="panel-heading">{{ __('Search') }}</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('What are you looking for?') }}" />
     </div>
     <label for="sort">{{ __('Sort by') }}:</label>
      <select id="sort">
  <option value="actual value 1">{{ __('Level') }}</option>
  <option value="actual value 2">{{ __('Strength') }}</option>
  <option value="actual value 3">{{ __('Duels Won') }}</option>
</select>
     <div class="table-responsive">
      <!-- <h3 align="center">Total Data : <span id="total_records"></span></h3> -->
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>{{ __('Name') }}</th>
         <th>{{ __('Strength') }}</th>
         <th>{{ __('Level') }}</th>
         <th>{{ __('Duels Won') }}</th>
         @can('update-guild', $guild)
         <th>{{ __('Kick') }}</th>
         @endcan
        </tr>
       </thead>
       <tbody>
       </tbody>
      </table>
     </div>
    </div>    
   </div>

<div class="subdescr">
<div class="descr" style="margin-right: -400px;"> 
    <i style="margin-top: -20px;">{{ __('Description') }}</i>
    @can('delete-guild', $guild)
 <form method="PosT" id="flagging_forma" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'update'], ['guild' => $guild->id]) }}>
 <textarea rows="2" cols="25" type="text" style="background-color: rgb(201, 168, 125);" name="guild_description" id="input_field" value="{{ $guild->description }}">{{ $guild->description }}</textarea>
 <input type="hidden" name="guild_id" value="{{ $guild->id }}">   
 @csrf
    @method('PuT')
    <button type="submit" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; right: 10px;">{{ __('Update') }}</button>
 </form>
 @else

   {{$guild->description}}
 
 @endcan
 </div>
   {{ __('Owner') }}: {{$owner->name}}
</div>

@if($user->role != 'admin' || $owner->id == Auth::user()->active_character_id)
  @can('destroy', $guild)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'destroy'], [ 'guild' => $guild->id]) }}>
    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('{{ addslashes(__('Are you sure you wish to delete it?')) }}')">{{ __('Delete Guild') }}</button>
 </form>
 @endcan
 @endif

 @auth
 @if($user->active_character_id)

@can('leave-guild', $guild)
 <form method="PosT" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'leave'], ['id' => $guild->id]) }}>
    @csrf
    @method('PuT')
    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('{{ addslashes(__('Are you sure you wish to leave this guild?')) }}')">{{ __('Leave guild') }}</button>
 </form>
@endcan

@if($guild->isopen == "true")
@can('join-guild')
 <form method="PosT" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'join'], ['id' => $guild->id]) }}>
    @csrf
    @method('PuT')
    <button type="submit" class="btn btn-outline-light li-right play_as">{{ __('Join guild') }}</button>
 </form>
 @endcan
@endif
 @endif
 @endauth
</div>

</body>
@auth 
@can('index-users')
@include('layouts.partials.adminNavbar')
@endcan
@endauth
</html>
<script>
$(document).ready(function(){
 fetch_character_data();
 function fetch_character_data(query = '', sortValue=''){
  $.ajax({
   url:"{{ route('list_members.action', $guild->id) }}",
   method:'GET',
   data:{query:query, sortValue:sortValue},
   dataType:'json',
   success:function(data){
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }
var query = ''; var sortValue = '';
 $(document).on('keyup', '#search', function(){
  query = $(this).val();
  fetch_character_data(query, sortValue);
 });
 $("#sort").change(function () {
        sortValue = $("#sort").prop('selectedIndex');
        fetch_character_data(query, sortValue);
    });
});
</script>