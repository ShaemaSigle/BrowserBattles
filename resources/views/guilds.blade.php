<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>All guilds</title>
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
  background-color: rgb(222, 184, 135, 0.8);
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
 <h1>All of the guilds:</h1>
<?php $user = Auth::user(); use App\Models\Character; use App\Models\Guild;?>
 @auth 
 <?php $character = Character::where('id', '=', $user->active_character_id)->first();?>
 @endauth
 <div class="profile-container">
<div class="container-box">
   <div class="panel panel-default">
    <div class="panel-heading">Search Guilds</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Begin inputting the name of the guild..." />
      <select id="sort">
  <option value="actual value 1">MembersDesc</option>
  <option value="actual value 2">MembersAsc</option>
  <option value="actual value 3">Alfabetically</option>
</select>
     </div>
     <div class="table-responsive">
      <!-- <h3 align="center">Total Data : <span id="total_records"></span></h3> -->
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>Guild Name</th>
         <th>Members</th>
         <th>Description</th>
         <th>Is open</th>
         <th>View</th>
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
  @if($character && $character->guild_id==NULL)
 <a href="{{action([App\Http\Controllers\GuildController::class, 'create'])}}" class="btn btn-outline-light">Create a new guild</a>
 @elseif ($character && $character->guild_id!=NULL)
 Your guild: <?php $guild = Guild::findOrFail($character->guild_id); ?>{{$guild->name}}
 <a href="{{$guild->id}}/guild" class="btn btn-outline-light play_as">Press here to view</a>
 @endif
 @endauth
 </div>

</body>
</html>

<script>
$(document).ready(function(){
 fetch_guild_data();
 function fetch_guild_data(searchValue = '', sortValue = ''){
  $.ajax({
   url:"{{ route('guild_search.action') }}",
   method:'GET',
   data: {searchValue: searchValue,
    sortValue: sortValue
  },
   dataType:'json',
   success:function(data){
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }
 var sortValue; var searchValue;
 $("#sort").change(function () {
        sortValue = $("#sort :selected").text()
        fetch_guild_data(searchValue, sortValue);
    });
 $(document).on('keyup', '#search', function(){
  searchValue = $(this).val();
  fetch_guild_data(searchValue, sortValue);
 });
});
</script>