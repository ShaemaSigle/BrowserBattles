<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>All guilds</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
    <style>.play_as{
    height: 4vh;
    padding: 0px 5px 0px 5px;
    margin-right: 5px;
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
li{
    text-align: left;
}
</style>
</head>
<body>
@include('layouts.partials.navbar')
 <h1>All of the guilds:</h1>
<?php $user = Auth::user(); use App\Models\Character;?>
 <div class="profile-container">
 @if (count($guilds) == 0)
    <p class='error'>There are no records in the database!</p>
 @else
 <ul>
 @foreach ($guilds as $guild)
 <li class="guild">
 <div style="margin-top:15px;"> {{ $guild->name }} - {{ $guild->members_amount }} members
 <form method="GET" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'show'], [ 'id' => $guild->id]) }}>
    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
    @csrf
    @method('get')
    <button type="submit" class="btn btn-outline-light li-right play_as">Press to view</button>
 </form>
</div>
</li>
 @endforeach
 @endif
 </ul>

 @auth 
 <?php $character = Character::where('id', '=', $user->active_character_id)->first();?>
@if($character->guild_id==NULL)
 <a href="{{action([App\Http\Controllers\GuildController::class, 'create'])}}" class="btn btn-outline-light">Create a new guild</a>
 @endif
 @endauth
</div>

</body>
</html>