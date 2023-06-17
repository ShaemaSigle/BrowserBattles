<style>
.navbar{
    font-family: 'Montserrat', sans-serif;
    position: sticky;
    top: 0;
    padding: 0;
    display: inline-block;
    background-color: darksalmon; 
    border-radius: 0 0 2vw 2vw;
    width: 100%;
    height: 6vh;
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.23);
}
.container {
    height: 0px;
}
  li {
      display: block;
      color: #FFFFFF;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .navbar a:hover {
      background-color: salmon;
    }

    .navbar a.active {
      background-color: #FFC0CB;
    }

    .navbar a .nav-link{
      float: left;
    }

    .li-right {

      float: right;
      color:white;
    }
  </style>

<header class="navbar">
  <div class="container">
      <ul class="nav">
        <li><a href="{{action([App\Http\Controllers\HomeController::class, 'index'])}}" class="nav-link px-2 text-secondary">Home</a></li>
        @auth <?php $user = Auth::user(); ?>
        <li><a href="{{action([App\Http\Controllers\UserController::class, 'show'])}}" class="nav-link px-2 text-white">Profile</a></li>
        <li><a href="{{action([App\Http\Controllers\GameController::class, 'index'])}}" class="nav-link px-2 text-white">Game</a></li>
        @endauth
        <li><a href="{{action([App\Http\Controllers\GuildController::class, 'index'])}}" class="nav-link px-2 text-white">Guild</a></li>
        <li><a href="#" class="nav-link px-2 text-white">Leaderboards</a></li>
        <li><a href="#" class="nav-link px-2 text-white">Suggest</a></li>
      </ul>
  </div>
  @auth <?php $user = Auth::user(); ?>
       {{auth()->user()->name}}
       <li style="padding-right: 15px;  padding-top:4px;"><a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2 li-right">Logout</a></li>
       <li class="li-right" style="padding-right: 8px; padding-top:4px;">You are now logged as {{$user->username}}</li>
  @endauth
  @guest
       <li style="padding-right: 15px; padding-top:4px;"><a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2 li-right">Login</a></li>
       <li style="padding-right: 15px;" ><a href="{{ route('register.perform') }}" class="btn btn-outline-light li-right">Sign-up</a></li>
  @endguest
</header>
