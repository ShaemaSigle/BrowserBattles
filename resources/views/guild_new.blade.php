<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>New guild</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
</head>
<body>

@include('layouts.partials.navbar')

@auth
    <?php $user = Auth::user(); ?>
        <h1>You are about to create a new guild. {{ $user->username }} will be the owner. </h1>
        <p class="lead">Only authenticated users can access this section.</p>
@endauth
 <h1>New guild creation:</h1>
 <form method="POST" action={{action([App\Http\Controllers\GuildController::class, 'store']) }}>
 @csrf
 <input type="hidden" name="guild_owner" value="{{ $user->id }}">
 <label for='guild_name'>Guild name:</label>
 <input type="text" name="guild_name" id="guild_name">
 <button type="submit" value="Add">Save</button>
 </form>
</body>
</html>