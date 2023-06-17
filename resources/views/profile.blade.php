<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>My profile</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 


    <style>

.profile-container {
  width: 80vw;
  height: 70vh;
  margin: auto;
  padding: 40px;
  background-color: rgb(222, 184, 135, 0.8);
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
.profile-form button {
  background-color: #FFC0CB;
  border: none;
  color: #FFFFFF;
  padding: 12px 20px;
  border-radius: 4px;
  width: 100%;
  cursor: pointer;
  font-size: 16px;
}

.profile-form button:hover {
  background-color: #FFB6C1;
}
</style>


</head>
<body>
@include('layouts.partials.navbar')
 <h1>@auth <?php $user = Auth::user(); ?> Wow, it's {{$user->username}}'s profile!</h1>
  <div class="profile-container">
    <h2>Profile</h2>
    <p><strong>Email:</strong> {{$user->email}}</p>
    <p><strong>Name:</strong> {{$user->username}}</p>
    <p><strong>Your Role:</strong> {{$user->role}}</p>
    @endauth
    @if (count($characters) == 0)
 <p class='error'>You don't have any characters!</p>
 @else
 <ul>
 <p>Your characters:</p>
 @foreach ($characters as $character)
 <li>
 {{ $character->name }} - {{ $character->level }}
 </li>
 @endforeach
 </ul>
 @endif
    <form style="float: left" class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
        @csrf
        @method('put')
        <p>Wanna change things a little bit? You can do it here:</p>
      <input type="email" name="email"  id="email" placeholder="New Email" required>
      <button type="submit">Update Email</button>
    </form>
    <form style="float: left" class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
        @csrf
        @method('put')
        <p>Wanna change things a little bit? You can do it here:</p>
      <input type="name" name="name"  id="name"  placeholder="New Nickname" required>
      <button type="submit">Update Username</button>
    </form>
    <form style="float: left" class="profile-form" method="post" action={{ action([App\Http\Controllers\UserController::class, 'update'], 
        [ 'user' => $user]) }}>
        @csrf
        @method('put')
        <p>Wanna change things a little bit? You can do it here:</p>
      <input type="password" name="password"  id="password" placeholder="New Password" required>
      <button type="submit">Update Password</button>
    </form>

  </div>

</body>
</html>