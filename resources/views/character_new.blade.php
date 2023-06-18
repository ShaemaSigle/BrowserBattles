<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>New character</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css')}}"type="text/css" rel="stylesheet"> 

<style>

button {
  background-color: #FFC0CB;
  border: none;
  color: #FFFFFF;
  padding: 12px 20px;
  border-radius: 4px;
  width: 100%;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #FFB6C1;
}

</style>

</head>
<body>

@include('layouts.partials.navbar')

@auth
    <?php $user = Auth::user(); ?>
        <h1>You are about to create a new character. {{ $user->username }} will be the user bound to the character. </h1>
        <p class="lead">Creating a new character allows you to start playing from scratch. It will not erase your previous progress. 
            Only authenticated users can access this section.</p>
@endauth
 <h1>New character creation:</h1>
 <form style="width: 24vw; margin-left: 37%;" method="POST" action={{action([App\Http\Controllers\CharacterController::class, 'store']) }}>
 @csrf
 <input type="hidden" name="user_id" value="{{ $user->id }}">
 <label for='name'>Character name:</label>
 <input type="text" name="name" id="name">
 <button type="submit">Create character</button>
 </form>
</body>
</html>