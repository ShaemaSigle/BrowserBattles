<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FlaggedObjectController;
use App\Http\Middleware\RoutingMiddleware;

Route::redirect('/', 'users');
//


Route::group(['namespace' => 'App\Http\Controllers'], function(){ 
    //Routes available to everyone
    Route::get('guilds', 'GuildController@index');
    Route::get('{id}/guild', 'GuildController@show');
    Route::get('/guilds/action', 'GuildController@action')->name('guild_search.action');
    Route::get('{id}/guild/list_members', [GuildController::class,'list_members'])->name('list_members.action');
    Route::view('/leaderboards', 'leaderboards');
    Route::get('/leaderboards/live', [CharacterController::class,'live'])->name('live_search.action');
    Route::get('/', 'HomeController@index')->name('home.index');
    
    Route::get('/lang/{locale}', [\App\Http\Controllers\LocalizationController::class,'lang_change'])->name('lang.change');
    //Routes for guests only
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });
    //Routes for authenticated users only
    Route::group(['middleware' => ['auth']], function() {
        //For all authenticated users
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        //Route::get('game', [GameController::class, 'index']);
        Route::get('game/{id}', [CharacterController::class, 'show']);
        Route::get('game/encounter/{id}', [EncounterController::class,'show']);
        Route::get('game/duel/{enemy_char_id}', [EncounterController::class,'duel']);
        Route::get('profile', [UserController::class,'show']);
        Route::get('guilds/create', [GuildController::class,'create']);
        Route::get('characters/create', [CharacterController::class,'create']);
        Route::put('{id}/guild', [GuildController::class,'join']);
        Route::put('{id}/guild/leave', [GuildController::class,'leave']);
        //Moderator and Admin Routes
        Route::put('flag', [FlaggedObjectController::class,'store'])->middleware('ensure.role:mod');
        Route::get('users', [UserController::class,'index'])->middleware('ensure.role:mod');
        Route::get('/users/search', [UserController::class,'search'])->name('user_search.action')->middleware('ensure.role:mod');
        //Admin routes
        Route::get('flagged', [FlaggedObjectController::class,'index'])->middleware('ensure.role:admin');
        Route::get('/flag/search', [FlaggedObjectController::class,'search'])->name('flag_search.action')->middleware('ensure.role:admin');
        Route::get('/flagged/{id}/delete', [FlaggedObjectController::class,'destroy'])->middleware('ensure.role:admin');
    });
});
Route::resource('guild', GuildController::class, ['except' =>['index', 'create']]);
Route::resource('character', CharacterController::class, ['except' =>['index', 'create', 'show']]);
Route::resource('encounter', EncounterController::class, ['except' =>['index', 'create']]);
Route::resource('users', UserController::class, ['except' =>['index', 'search']]);

Route::fallback(function () {
    return view('oops');
})->name('fallback');