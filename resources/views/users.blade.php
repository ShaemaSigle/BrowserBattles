<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Users</title>
 <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
</head>
<body>
@include('layouts.partials.navbar')
 <h1>Список пидоров:</h1>
 @if (count($users) == 0)
 <p class='error'>There are no records in the database!</p>
 @else
 <ul>
 @foreach ($users as $user)
 <li>
 {{ $user->username }} - {{ $user->role }}
 </li>
 @endforeach
 </ul>
 @endif
</body>
</html>