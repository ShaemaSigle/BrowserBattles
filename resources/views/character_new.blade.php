<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>{{ __('Create a new character') }}</title>
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
        <h1>{{ __('You are about to create a new character.') }} {{ $user->username }} {{ __('will be the owner.') }}</h1>
        <p class="lead">{{ __('Creating a new character allows you to start playing from scratch. It will not erase your previous progress.') }}</p>
@endauth
 <form style="width: 24vw; margin-left: 37%;" method="POST" action={{action([App\Http\Controllers\CharacterController::class, 'store']) }}>
 @csrf
 <input type="hidden" name="user_id" value="{{ $user->id }}">
 <label for='name'>{{ __('Name') }}:</label>
 <input type="text" name="name" id="name">
 @if ($errors->has('name'))
  <p style="font-size: 20px;"  class="text-danger text-left">{{ $errors->first('name') }}</p>
  @endif
 <button type="submit">{{ __('Create') }}</button>
 </form>
</body>
</html>