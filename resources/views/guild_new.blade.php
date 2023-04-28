<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>New guild</title>
</head>
<body>
 <h1>New guild creation:</h1>
 <form method="POST" action={{action([App\Http\Controllers\GuildController::class, 'store']) }}>
 @csrf
 <label for='guild_name'>Guild name:</label>
 <input type="text" name="guild_name" id="guild_name">
 <button type="submit" value="Add">Save</button>
 </form>
</body>
</html>