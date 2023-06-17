<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>All guilds</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
</head>
<body>
@include('layouts.partials.navbar')
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