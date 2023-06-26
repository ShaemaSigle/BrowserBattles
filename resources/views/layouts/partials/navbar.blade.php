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
  .navbar a {
      
      color: #FFFFFF;
      text-align: center;
      transition: background-color 0.3s ease;
    }
    li{
      display: block;
      text-decoration: none;
    }

    .navbar a:hover, button:hover {
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
    .blankit{
    border: none;
    background:none;
    float: left;
    position: relative;
    color:white;
}
  </style>

<header class="navbar">
  <div class="container">
      <ul class="nav">
      <?php use App\Models\Character; ?>
        <li><a href="{{action([App\Http\Controllers\HomeController::class, 'index'])}}" class="nav-link px-2 text-secondary">{{ __('Home') }}</a></li>
        @auth 
        <?php 
          $user = Auth::user();  
          $character = '0';
          if($user->active_character_id != NULL){
            $character = Character::where('id', '=', $user->active_character_id)->first();
          $address='game/'.$character->id;
          } 
          ?>
        <li><a href="/profile" class="nav-link px-2 text-white">{{ __('Profile') }}</a></li>
        <li><a href="{{action([App\Http\Controllers\CharacterController::class, 'show'], ['id'=>$character]) }}" class="nav-link px-2 text-white">{{ __('Game') }}</a></li>
        @endauth
        <li><a href="{{action([App\Http\Controllers\GuildController::class, 'index'])}}" class="nav-link px-2 text-white">{{ __('Guilds') }}</a></li>
        <li><a href="/leaderboards" class="nav-link px-2 text-white">{{ __('Leaderboards') }}</a></li>
          <li class="nav-link px-2 text-white">
              <a href="{{route('lang.change','en')}}">{{ __('English') }}</a>
          </li>
          <li class="nav-link px-2 text-white">
              <a href="{{route('lang.change','ru')}}">{{ __('Russian') }}</a>
          </li>
          <li class="nav-link px-2 text-white">
              <a href="{{route('lang.change','lv')}}">{{ __('Latvian') }}</a>
          </li>
      </ul>
  </div>

  @auth 
       {{auth()->user()->name}}
       <li style="padding-right: 15px;  padding-top:4px;"><a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2 li-right">{{ __('Logout') }}</a></li>
       @if(auth()->user()->active_character_id != NULL)
       <li class="li-right" style="padding-right: 8px; padding-top:4px;">{{ __('playing as ') }}{{$character->name}}</li>
       @endif
       <li class="li-right" style="padding-right: 8px; padding-top:4px;">{{ __('You are now logged as ') }}{{$user->username}}</li>

  @endauth
  @guest
       <li style="padding-right: 15px; padding-top:4px;"><a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2 li-right">{{ __('Login') }}</a></li>
       <li style="padding-right: 15px;" ><a href="{{ route('register.perform') }}" class="btn btn-outline-light li-right">{{ __('Sign-up') }}</a></li>
  @endguest
</header>

