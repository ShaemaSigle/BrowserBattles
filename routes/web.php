<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CharacterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::redirect('/', 'users');
Route::resource('users', UserController::class);


/*foreach ($characters as $character){
    if(auth()->user()->id == $character->user_id){
        
    }
}
    */

Route::resource('guild', GuildController::class, ['except' =>['index', 'create']]);
Route::resource('character', CharacterController::class, ['except' =>['index', 'create']]);
Route::get('guilds', [GuildController::class,'index']);
Route::get('game', [GameController::class, 'index']);
Route::get('{id}/guild', [GuildController::class,'show']);
Route::get('profile', [UserController::class,'show']);
Route::get('guilds/create', [GuildController::class,'create']);
Route::get('characters/create', [CharacterController::class,'create']);


/* Login, Logout and Register Routes */
Route::group(['namespace' => 'App\Http\Controllers'], function()
{ 
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::group(['middleware' => ['guest']], function() {
        // Register Routes
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        //Login Routes
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });
    Route::group(['middleware' => ['auth']], function() {
        //Logout Route
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
/* ENDOF Login, Logout and Register Routes */