<style>
.navbar{
    font-family: 'Montserrat', sans-serif;
    position: sticky;
    top: 0;
    background-color: darksalmon; 
    border-radius: 0 0 2vw 2vw;
    width: 100%;
    height: 6vh;
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.23);
}

.li-right {
      float: right;
    }

    .navbar a {
      float: left;
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
  </style>




<header class="navbar">
  <div class="container">
    <div>
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-lg-auto mb-2 mr-10 justify-content-center mb-md-0">
        <li><a href="{{action([App\Http\Controllers\HomeController::class, 'index'])}}" class="nav-link px-2 text-secondary">Home</a></li>
        <li><a href="#" class="nav-link px-2 text-white">Profile</a></li>
        <li><a href="{{action([App\Http\Controllers\GameController::class, 'index'])}}" class="nav-link px-2 text-white">Game</a></li>
        <li><a href="{{action([App\Http\Controllers\GuildController::class, 'index'])}}" class="nav-link px-2 text-white">Guild</a></li>
        <li><a href="#" class="nav-link px-2 text-white">Leaderboards</a></li>
        <li><a href="#" class="nav-link px-2 text-white">Suggest</a></li>

        @auth <?php $user = Auth::user(); ?>
       
       {{auth()->user()->name}}
       
       <li class="li-right">You are now logged as {{$user->username}}</li>
       <li><a href="{{ route('logout.perform') }}" class="li-right">Logout</a></li>
       @endauth


      </ul>


      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>