<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>New guild</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
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
}</style>
</head>
<body>

@include('layouts.partials.navbar')


    <?php $user = Auth::user(); use App\Models\Character; $character = Character::where('id', '=', $user->active_character_id)->first();?>
        <h1>{{ __('You are about to create a new guild.') }} {{ $character->name }} {{ __('will be the owner.') }}</h1>

 <form style="width: 24vw; margin-left: 37%;" method="POST" action={{action([App\Http\Controllers\GuildController::class, 'store']) }}>
 @csrf
 <input type="hidden" name="guild_owner" value="{{ $character->id }}">
 <label for='guild_name'>{{ __('Name') }}:</label>
 <input type="text" name="guild_name" id="guild_name">
 @if ($errors->has('guild_name'))
  <p style="font-size: 20px;"  class="text-danger text-left">{{ $errors->first('guild_name') }}</p>
  @endif
 <label for='guild_description'>{{ __('Description') }} ({{ __('optional') }}):</label>
 <input type="text" name="guild_description" id="guild_description">
 <button type="submit" value="Add">{{ __('Create') }}</button>
 </form>
</body>
</html>