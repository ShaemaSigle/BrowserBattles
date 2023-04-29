<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
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
      </ul>

      
      @include('layouts.partials.loggedas')

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>