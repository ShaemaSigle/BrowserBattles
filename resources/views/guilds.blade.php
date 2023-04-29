<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>All guilds</title>
</head>
<body>
 <h1>All of the guilds:</h1>
 @if (count($guilds) == 0)
 <p class='error'>There are no records in the database!</p>
 @else
 <ul>
 @foreach ($guilds as $guild)
 <li>
 {{ $guild->name }} - {{ $guild->members_amount }}
 </li>
 @endforeach
 </ul>
 @endif
</body>
</html>