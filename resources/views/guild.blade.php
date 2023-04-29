<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Guild view</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
</head>
<body>

@include('layouts.partials.navbar')

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