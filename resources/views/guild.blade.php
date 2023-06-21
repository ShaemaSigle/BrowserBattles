<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Guild view</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 



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

@include('layouts.partials.navbar')

 <h1>Це наша гильдия {{$guild->name}}:</h1>
 @if (count($characters) == 0)
 <p class='error'>There are no records in the database!</p>
 @else
 <ul>
 @foreach ($characters as $character)
 <li>
 {{ $character->name }} - {{ $character->level }}
 </li>
 @endforeach
 </ul>
 @endif
 <?php $user = Auth::user();?>
 @can('destroy', $guild)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'destroy'], [ 'guild' => $guild->id]) }}>
    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-light li-right play_as">Delete guild</button>
 </form>
 @endcan
 
</body>
</html>