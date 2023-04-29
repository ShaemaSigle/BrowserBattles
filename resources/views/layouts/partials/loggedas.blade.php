@auth <?php $user = Auth::user(); ?>
       
{{auth()->user()->name}}

<p class="float-right col-lg-auto justify-content-center mb-md-0">You are now logged as {{$user->username}}</p>
<a href="{{ route('logout.perform') }}" class="btn btn-outline-light float-right">Logout</a>
@endauth