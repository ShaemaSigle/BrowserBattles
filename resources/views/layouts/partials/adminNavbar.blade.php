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
    #flagging_form {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      height: 30%;
      width: 30%;
      background-color: rgba(192, 159, 116);
      transform: translate(-50%, -50%);
      padding: 20px;
      border: 1px solid gray;
      z-index: 9999;
    }
    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9995;
    }
  </style>
<div class="Anavbar">
    <div id="overlay"></div>
    <div class="Acontainer">
        <ul class="nav">
            <li><a href="{{ action([App\Http\Controllers\UserController::class, 'index']) }}" class="nav-link px-2 text-white sl">{{ __('Users List') }}</a></li>
            @can('delete-user')
            <li><a href="{{ action([App\Http\Controllers\FlaggedObjectController::class, 'index']) }}" class="nav-link px-2 text-white sl">{{ __('Flagged List') }}</a></li>
            @endcan
            @if(isset($guild) && $guild->owner != Auth::user()->id)
                @can('destroy', $guild) 
                <form method="POST" style="padding-left: 10px; padding-top:8px;" class="blankit" action="{{ action([App\Http\Controllers\GuildController::class, 'destroy'], ['guild' => $guild->id]) }}">
                    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('Вы уверены, что хотите удалить эту гильдию?')">{{ __('Delete Guild') }}</button>
                </form>
                @endcan
                <button id="showButton" style="margin-left: 10px; margin-top:8px;" class="btn btn-outline-light li-right play_as">{{ __('Flag Guild') }}</button>
                <form method="POST" id="flagging_form" class="blankit" action="{{ action([App\Http\Controllers\FlaggedObjectController::class, 'store'], ['guild' => $guild->id]) }}">
                    <input type="hidden" name="guild_id" id="guild_id" value="{{ $guild->id }}">
                    <input type="text" name="reason" style="width: 90%; height: 80%" placeholder="{{ __('Enter reason for flagging') }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; right: 10px;">{{ __('Flag Guild') }}</button>
                    <button type="button" id="closeButton" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; left: 10px;">{{ __('Cancel') }}</button>
                </form>
            @endif 

            @if(isset($Wuser) && $Wuser->id != Auth::user()->id)
                @can('destroy', $Wuser) 
                <form method="POST" style="padding-left: 10px; padding-top:8px;" class="blankit" action="{{ action([App\Http\Controllers\UserController::class, 'destroy'], ['user' => $Wuser->id]) }}">
                    <input type="hidden" name="user_id" value="{{ $Wuser->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-light li-right play_as" onclick="return confirm('{{ addslashes(__('Delete User')) }}?')">{{ __('Delete User') }}</button>
                </form>
                @endcan
                <button id="showButton" style="margin-left: 10px; margin-top:8px;" class="btn btn-outline-light li-right play_as">{{ __('Flag User') }}</button>
                <form method="POST" id="flagging_form" class="blankit" action="{{ action([App\Http\Controllers\FlaggedObjectController::class, 'store'], ['user' => $Wuser->id]) }}">
                    <input type="hidden" name="user_id" value="{{ $Wuser->id }}">
                    <input type="text" name="reason" style="width: 90%; height: 80%" placeholder="{{ __('Enter reason for flagging') }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; right: 10px;">{{ __('Flag User') }}</button>
                    <button type="button" id="closeButton" class="btn btn-outline-light li-right play_as" style="position: absolute; bottom: 10px; left: 10px;">{{ __('Cancel') }}</button>
                </form>
            @endif 
        </div>
        @if(auth()->user()->role == 'admin')
        <li class="li-right" style="padding-right: 8px; padding-top:13px;">{{ __('You have admin powers!') }}</li>
        @elseif(auth()->user()->role == 'mod')
        <li class="li-right" style="padding-right: 8px; padding-top:13px;">{{ __('You have moderator powers!') }}</li>
        @endif
  </ul>
    
</header>
<script>
    var showButton = document.getElementById("showButton");
    var container = document.getElementById("flagging_form");
    var closeButton = document.getElementById("closeButton");
    var overlay = document.getElementById("overlay");
    
    if(showButton != null){
      showButton.addEventListener("click", function() {
        container.style.display = "block";
        overlay.style.display = "block";
      });
    } 
    if(closeButton != null)
    {closeButton.addEventListener("click", function() {
      container.style.display = "none";
      overlay.style.display = "none";
    });}
  </script>