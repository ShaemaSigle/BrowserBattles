<style>
.Anavbar{
    font-family: 'Montserrat', sans-serif;
    background-color: #cf5227; 
    border-radius: 2vw 2vw 0 0 ;
    padding-left: 20px;
    padding-right: 20px;
    height: 6vh;
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.23);
    position: fixed;
    bottom: 0;
    right: 10%; 
    width: 80%;
}
.Acontainer {
    height: 0px;
}
  .Anavbar li {
      
      color: #FFFFFF;
      text-align: center;
      padding-top: 5px;
      transition: background-color 0.3s ease;
    }
    li{
      display: block;
      text-decoration: none;
    }

    .sl:hover {
      background-color: #c73402;
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

<div class="Anavbar">
  <div class="Acontainer">
      <ul class="nav">
        <li><a href="{{action([App\Http\Controllers\UserController::class, 'index'])}}" class="nav-link px-2 text-white sl">Users list</a></li>
        <li><a href="{{action([App\Http\Controllers\UserController::class, 'index'])}}" class="nav-link px-2 text-white sl">Flagged list</a></li>
        @if(isset($guild))
        @can('destroy', $guild) 
        <form method="POST" style="padding-left: 10px; padding-top:8px;" class="blankit" action={{action([App\Http\Controllers\GuildController::class, 'destroy'], [ 'guild' => $guild->id]) }}>
    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('Are you sure you wish to delete this guild?')">Delete guild</button>
 </form>
 @endcan
 @endif
        
  </div>
       @if(auth()->user()->role == 'admin')
       <li class="li-right" style="padding-right: 8px; padding-top:13px;">You have admin powers!</li>
       @elseif(auth()->user()->role == 'mod')
       <li class="li-right" style="padding-right: 8px; padding-top:4px;">You have moderator powers!</li>
       @endif
</header>
