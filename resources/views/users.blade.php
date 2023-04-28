<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Users</title>
</head>
<body>
 <h1>Список пидоров:</h1>
 @if (count($users) == 0)
 <p class='error'>There are no records in the database!</p>
 @else
 <ul>
 @foreach ($users as $user)
 <li>
 {{ $user->name }} - {{ $user->role }}
 </li>
 @endforeach
 </ul>
 @endif
</body>
</html>