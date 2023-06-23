<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>My profile</title>
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

</style>
</head>

<body>
@include('layouts.partials.navbar')
 <h1>@auth <?php 
    $user = Auth::user(); 
    if($user->profpic_path != NULL) $image =  $user->profpic_path;
    else $image = 'default_knight.png';
 ?> 
 
 Wow, it's {{$user->username}}'s profile!</h1>
  <div class="profile-container">
    <h2>Profile</h2>
    <br>
    <strong>Email:</strong> {{$user->email}}<br>
    <strong>Name:</strong> {{$user->username}}<br>
    <strong>Your Role:</strong> {{$user->role}}<br>
    <div style="float: right; margin-top: -20vh; text-align:right;"> 
    Here's your profile picture!   
    </div><br>
      <div style="float: right; margin-top: -20vh; text-align:right;"> 
  <img src="{{asset('assets/img/'.$image)}}" alt="" height="250px" width="250px">
    </div>
    <br>
    @if (count($characters) == 0)
 You don't have any characters!
 @else
 <ul>
 <h3 style="padding-left: 0;">Your characters:</h3>
 @foreach ($characters as $character)
 <li class="character">
 <form method="POST" class="blankit" action="{{action([App\Http\Controllers\CharacterController::class, 'destroy'],  $character->id) }}">
    @csrf
    @method('DELETE')
    <button class="btn btn-outline-light li-right play_as" style="background-color: red;" type="submit" value="delete" onclick="return confirm('Are you sure you wish to delete this character?')">delete</button>
    </form>
 <div style="margin-top:15px;">{{ $character->name }} - {{ $character->level }} LVL  @if($character->id != $user->active_character_id)
 <form method="POST" class="blankit" action={{action([App\Http\Controllers\UserController::class, 'update'], [ 'user' => $user]) }}>
    <input type="hidden" name="active_character_id" id="active_character_id" value="{{ $character->id }}">
    @csrf
    @method('put')
    <button type="submit" class="btn btn-outline-light li-right play_as">Press to play as</button>
 </form>
</div>
 @endif
</li>
 @endforeach
 
 </ul>
 @endif
 <br>
 <a href="{{action([App\Http\Controllers\CharacterController::class, 'create'])}}" class="btn btn-outline-light">Create a new character</a>
<br><br><hr><br>Here you can edit your account.
<br> <br>

    <div style="float: left;" class="form-group form-floating mb-3">
    <form class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
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
    <form class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
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
        
        <form style="float: left;" class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
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
        <form style="float: left; margin-top: -10vh;"  class="profile-form"  action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }} method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <label for="ProfPic">Upload a new Profile Picture</label>
          <input type="file" name="image" class="form-control">
          @if ($errors->has('image'))
                <span class="text-danger text-left">{{ $errors->first('image') }}</span>
            @endif
          <button type="submit">Upload</button>
      </form></div>
<form class="blankitNoFloat" method="POST" action="{{action([App\Http\Controllers\UserController::class, 'destroy'],  $user->id) }}">
    @csrf
    @method('DELETE')
    You can also <button class="deletion" type="submit" value="delete" onclick="return confirm('Are you sure you wish to delete this account?')">delete this account</button>
    </form>
</div>
@endauth
</body>
</html>