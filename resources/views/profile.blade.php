<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>{{$Wuser->username}}'s profile</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
    <style>
.profile-container {
  width: 80%;
  height: fit-content;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135);
  border-radius: 8px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.profile-form input[type="email"],
.profile-form input[type="name"],
.profile-form input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #DDDDDD;
  border-radius: 4px;
  margin-bottom: 10px;
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
.blankitNoFloat{
    border: none;
    background:none;
    padding: 0;
    width: fit-content;
}
ul{
  padding: 0;
}
.flagging_form_char {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      height: 30%;
      width: 30%;
      background-color: rgba(192, 159, 116);
      transform: translate(-50%, -50%);
      padding: 20px;
      border: 1px solid gray;
      z-index: 9999;
    }

</style>
</head>

<body>
@include('layouts.partials.navbar')
 <h1>@auth <?php 
    //$user = Auth::user(); 
    if($Wuser->profpic_path != NULL) $image =  $Wuser->profpic_path;
    else $image = 'default_knight.png';
 ?> 
 
 Wow, it's {{$Wuser->username}}'s profile!</h1>
  <div class="profile-container">
    <h2>Profile</h2>
    <br>
    <strong>Email:</strong> {{$Wuser->email}}<br>
    <strong>Name:</strong> {{$Wuser->username}}<br>
    <strong>Role:</strong> {{$Wuser->role}}<br>
    <div style="float: right; margin-top: -20vh; text-align:right;"> 
    Profile picture   
    </div><br>
      <div style="float: right; margin-top: -20vh; text-align:right;"> 
  <img src="{{asset('assets/img/'.$image)}}" alt="" height="250px" width="250px">
    </div>
    <br>
    @if (count($characters) == 0)
 No characters found!
 @else
 <ul>
 <h3 style="padding-left: 0;">Characters:</h3>
 @foreach ($characters as $character)
 <li class="character">
    @can('delete-user', $Wuser)
 <form method="POST" class="blankit" action="{{action([App\Http\Controllers\CharacterController::class, 'destroy'],  $character->id) }}">
    @csrf
    @method('DELETE')
    <button class="btn btn-outline-light li-right play_as" style="background-color: red;" type="submit" value="delete" onclick="return confirm('Are you sure you wish to delete this character?')">delete</button>
    </form>
    @endcan
    @if($Wuser->id != Auth::user()->id)
    @can('index-users')
    <button style="float: left;" class="btn btn-outline-light li-right play_as showButton">Flag</button>
    <form method="POST" class="flagging_form_char" class="blankit" action={{action([App\Http\Controllers\FlaggedObjectController::class, 'store'], [ 'user' => $Wuser->id]) }}>
            <input type="hidden" name="character_id" value="{{ $character->id }}">
            <input type="text" name="reason" style="width: 90%; height: 80%" placeholder="Enter a reason for flagging">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; right: 10px;">Flag Character</button>
            <button type="button" id="closeButtonChar" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; left: 10px;">Cancel</button>
        </form>
    @endcan
    @endif
 <div style="margin-top:15px;">{{ $character->name }}: {{ $character->strength }} strength on {{ $character->level }} LVL  @if($character->id != $Wuser->active_character_id)
 @if($character->user_id == Auth::user()->id)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\UserController::class, 'update'], [ 'user' => $Wuser]) }}>
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">Press to play as</button>
 </form>
 @endif
</div>
 @endif
</li>
 @endforeach

 </ul>
 @endif
 <br>
 @if($Wuser->id == Auth::user()->id)
 <a href="{{action([App\Http\Controllers\CharacterController::class, 'create'])}}" class="btn btn-outline-light">Create a new character</a>
@endif
@can('delete-user', $Wuser)
 <br><br><hr><br>Here you can edit this account.
<br> <br>

    <div style="float: left;" class="form-group form-floating mb-3">
    <form class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'],  $Wuser->id,
        [ 'user' => $Wuser]) }}>
        @csrf
        @method('put')
        <label for="floatingEmail">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
            <button type="submit">Update Email</button>
    </form>
        </div>
    <div style="float: left;" class="form-group form-floating mb-3">
    <form class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'],  $Wuser->id,
        [ 'user' => $Wuser]) }}>
        @csrf
        @method('put')
        <label for="floatingName">Username</label>
            <input type="name" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
            <button type="submit">Update Username</button>
    </form>
        </div>
        
        <form style="float: left;" class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'],  $Wuser->id,
        [ 'user' => $Wuser]) }}>
        @csrf
        @method('put')
        <div class="form-group form-floating mb-3">
        <label for="floatingPassword">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
        <label for="floatingConfirmPassword">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
                    @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
            <button type="submit">Update Password</button>
        </div>
        </form>
        <div class="form-group form-floating mb-3">
        <form style="float: left; margin-top: -10vh;"  class="profile-form"  action={{ action([App\Http\Controllers\UserController::class, 'update'],  $Wuser->id,
        [ 'user' => $Wuser]) }} method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <label for="ProfPic">Upload a new Profile Picture</label>
          <input type="file" name="image" class="form-control">
          @if ($errors->has('image'))
                <span class="text-danger text-left">{{ $errors->first('image') }}</span>
            @endif
          <button type="submit">Upload</button>
      </form></div>
<form class="blankitNoFloat" method="POST" action="{{action([App\Http\Controllers\UserController::class, 'destroy'],  $Wuser->id) }}">
    @csrf
    @method('DELETE')
    You can also <button class="deletion" type="submit" value="delete" onclick="return confirm('Are you sure you wish to delete this account?')">delete this account</button>
    </form>
    @endcan
</div>
@endauth
</body>
@auth 
@can('index-users')
@include('layouts.partials.adminNavbar')
@endcan
@endauth
</html>

<script>
    var showButtons = document.getElementsByClassName("showButton");
    var containersChar = document.getElementsByClassName("flagging_form_char");
    var closeButton = document.getElementById("closeButtonChar");
    var overlay = document.getElementById("overlay");
    
    for(let i = 0; i < showButtons.length; i++) {
        showButtons[i].addEventListener("click", function() {
            console.log("Clicked index: " + i);
            containersChar[i].style.display = "block";
            overlay.style.display = "block";
        })
    }

    closeButton.addEventListener("click", function() {
        containersChar.style.display = "none";
      overlay.style.display = "none";
    });
  </script>