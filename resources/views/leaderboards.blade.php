<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>{{ __('Leaderboards') }}</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .play_as{
    height: 4vh;
    padding: 0px 5px 0px 5px;
    width: fit-content;
    width:fit-content;
}
.blankit{
    border: none;
    background:none;
    padding: 0;
    float: left;
    position: relative;
}
.profile-container {
  width: 80vw;
  height: 80vh;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}
.table-responsive{
    overflow-y: scroll;
    height: 50vh;
}
</style>
</head>
<body>
@include('layouts.partials.navbar')
 <h1>{{ __('Leaderboards') }}</h1>
<?php $user = Auth::user(); use App\Models\Character; use App\Models\Guild;?>
 @auth 
 <?php $character = Character::where('id', '=', $user->active_character_id)->first();?>
 @endauth
 <div class="profile-container">
<div class="container-box">
   <div class="panel panel-default">
    <div class="panel-heading">{{ __('Choose leaderboard') }}:</div>
    <div class="panel-body">
     <div class="form-group">
          <select id="sort">
  <option value="actual value 1">{{ __('Level') }}</option>
  <option value="actual value 2">{{ __('Strength') }}</option>
  <option value="actual value 3">{{ __('Duels Won') }}</option>
</select>
     </div>
     <div class="table-responsive">
      <!-- <h3 align="center">Total Data : <span id="total_records"></span></h3> -->
      <table class="table table-striped table-bordered">
       <thead>
       <tr>
       <th>{{ __('Position') }}</th>
         <th>{{ __('Name') }}</th>
         <th>{{ __('Guild') }}</th>
         <th>{{ __('Strength') }}</th>
         <th>{{ __('Level') }}</th>
         <th>{{ __('Duels Won') }}</th>
         <th>{{ __('Ask for a duel') }}</th>
         @can('index-users')
         <th>{{ __('Owner') }}</th>
         @endcan
        </tr>
       </thead>
       <tbody>
       </tbody>
      </table>
     </div>
    </div>    
   </div>
  </div>
  <br>
  @auth
  @if($character)
  {{ __('Your position') }}: <b id="position"></b> 
 @endif
 @endauth
 </div>
 @auth 
 @if($user->role=='admin' || $user->role=='mod')
@include('layouts.partials.adminNavbar')
@endif
@endauth
</body>

</html>
<script>
$(document).ready(function(){
 fetch_character_data();
 function fetch_character_data(sortValue = ''){
  $.ajax({
   url:"{{ route('live_search.action') }}",
   method:'GET',
   data:{sortValue:sortValue},
   dataType:'json',
   success:function(data){
    $('tbody').html(data.table_data);
    $('#position').text(data.pos);
   }
  })
 }

 $("#sort").change(function () {
        sortValue = $("#sort").prop('selectedIndex');
        fetch_character_data(sortValue);
    });
});
</script>