<!DOCTYPE html>
<html>
  <head>
    <title>My Game</title>
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
  </head>
  <body>


  @include('layouts.partials.navbar')

    <h1>Welcome to My Game</h1>
    <p>This is a fun and exciting game. Get ready to play!</p>
    <div id="game-container">
        <button onclick="alert('Button clicked!')">Click me</button>
    </div>
  </body>
</html>