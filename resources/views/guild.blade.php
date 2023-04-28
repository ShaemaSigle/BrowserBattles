<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Guild view</title>
</head>
<body>
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
</body>
</html>