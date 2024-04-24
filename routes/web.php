<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('users','users.showAll')->name('users.all');
Route::view('game','game.show')->name('game.show');

Route::controller(ChatController::class)->group(function(){
    Route::get('chat','showChat')->name('chat.show');
    Route::post('chat/send','messageReceived')->name('chat.messageReceived');
    Route::post('chat/greet/{user}','greet')->name('chat.greet');
});

