<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\CharacterController;

Route::redirect('/', 'users');
Route::resource('users', UserController::class);


Route::get('guilds', [GuildController::class,'index']);
Route::get('game', [GameController::class, 'index']);
Route::get('{id}/guild', [GuildController::class,'show']);
Route::get('profile', [UserController::class,'show']);
Route::get('guilds/create', [GuildController::class,'create']);
Route::get('characters/create', [CharacterController::class,'create']);
Route::get('game/encounter/{id}', [EncounterController::class,'show']);

Route::get('/guilds/action', [GuildController::class,'action'])->name('guild_search.action');
Route::put('{id}/guild', [GuildController::class,'join']);
Route::get('{id}/guild/list_members', [GuildController::class,'list_members'])->name('list_members.action');

Route::resource('guild', GuildController::class, ['except' =>['index', 'create']]);
Route::resource('character', CharacterController::class, ['except' =>['index', 'create']]);
Route::resource('encounter', EncounterController::class, ['except' =>['index', 'create']]);

Route::fallback(function () {
    return view('oops');
});

// Login, Logout and Register stuff
Route::group(['namespace' => 'App\Http\Controllers'], function(){ 
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});