<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\CharacterController;
use App\Http\Middleware\RoutingMiddleware;

Route::redirect('/', 'users');
Route::resource('users', UserController::class);

//Routes available to everyone
Route::get('guilds', [GuildController::class,'index']);
Route::get('{id}/guild', [GuildController::class,'show']);
Route::get('/guilds/action', [GuildController::class,'action'])->name('guild_search.action');
Route::get('{id}/guild/list_members', [GuildController::class,'list_members'])->name('list_members.action');
Route::view('/leaderboards', 'leaderboards');
Route::get('/leaderboards/live', [CharacterController::class,'live'])->name('live_search.action');

//Routes available to certain roles
Route::group(['namespace' => 'App\Http\Controllers'], function(){ 
    Route::get('/', 'HomeController@index')->name('home.index');
    //Routes for guests only
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });
    //Routes for authenticated users only
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('game', [GameController::class, 'index']);//->middleware(RoutingMiddleware::class);
        Route::get('game/encounter/{id}', [EncounterController::class,'show']);
        Route::get('profile', [UserController::class,'show']);
        Route::get('guilds/create', [GuildController::class,'create']);
        Route::get('characters/create', [CharacterController::class,'create']);
        Route::put('{id}/guild', [GuildController::class,'join']); //!!!!
        Route::put('{id}/guild/leave', [GuildController::class,'leave']); //!!!!
        //Route::get('users', [CharacterController::class,'create'])->middleware(RoutingMiddleware::class);
    });
});

Route::fallback(function () {
    return view('oops');
})->name('fallback');

Route::resource('guild', GuildController::class, ['except' =>['index', 'create']]);
Route::resource('character', CharacterController::class, ['except' =>['index', 'create']]);
Route::resource('encounter', EncounterController::class, ['except' =>['index', 'create']]);

