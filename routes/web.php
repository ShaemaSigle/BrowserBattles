<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuildController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/', 'users');
Route::resource('users', UserController::class);
Route::resource('guild', GuildController::class, ['except' =>['index', 'create']]);
Route::get('{id}/guild', [GuildController::class,'index']);
Route::get('guilds/create', [GuildController::class,'create']);

