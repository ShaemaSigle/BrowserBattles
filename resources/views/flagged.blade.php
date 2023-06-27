<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>{{ __('Flagged List') }}</title>
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
 <h1>{{ __('All of the flagged objects') }}:</h1>
<?php $user = Auth::user(); use App\Models\Character; use App\Models\Guild;?>
 @auth 
 <?php $character = Character::where('id', '=', $user->active_character_id)->first();?>
 @endauth
 <div class="profile-container">
<div class="container-box">
   <div class="panel panel-default">
    <div class="panel-heading">{{ __('Filter Objects') }}</div>
    <div class="panel-body">
     <div class="form-group">
      <div>
        <label for="character">{{ __('Character') }}</label>
        <input type="checkbox" id="character" name="checkboxes[]" value="character" checked>
    </div>

    <div>
        <label for="user">{{ __('User') }}</label>
        <input type="checkbox" id="user" name="checkboxes[]" value="user" checked>
    </div>

    <div>
        <label for="guild">{{ __('Guild') }}</label>
        <input type="checkbox" id="guild" name="checkboxes[]" value="guild" checked>
    </div>
     </div>
     
     <div class="table-responsive">
      <!-- <h3 align="center">Total Data : <span id="total_records"></span></h3> -->
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
        <th>{{ __('Type') }}</th>
         <th>{{ __('Reason') }}</th>
         <th>{{ __('Flag Date') }}</th>
         <th>{{ __('View') }}</th>
         <th>{{ __('Dismiss') }}</th>
        </tr>
       </thead>
       <tbody>
       </tbody>
      </table>
     </div>
    </div>    
   </div>
  </div>
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
 fetch_flag_data();
 function fetch_flag_data(showGuilds = 1, showCharacters = 1, showUsers = 1){
  $.ajax({
   url:"{{ route('flag_search.action') }}",
   method:'GET',
   data: {showGuilds: showGuilds,
    showCharacters: showCharacters,
    showUsers: showUsers
  },
   dataType:'json',
   success:function(data){
    $('tbody').html(data.table_data);
    //$('#total_records').text(data.total_data);
   }
  })
 }
 var showGuilds = 1; 
 var showCharacters = 1; 
 var showUsers = 1;

 $('input[type="checkbox"]').change(function() {
    if(this.id == 'guild'){
      if(showGuilds == 0) showGuilds = 1;
      else if(showGuilds == 1) showGuilds = 0;
    }
    if(this.id == 'user'){
      if(showUsers == 0) showUsers = 1;
      else if(showUsers == 1) showUsers = 0;
    }
    if(this.id == 'character'){
      if(showCharacters == 0) showCharacters = 1;
      else if(showCharacters == 1) showCharacters = 0;
    }
    fetch_flag_data(showGuilds, showCharacters, showUsers);
  });
});
</script>