<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});



Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/user/friends',[UserController::class,'showFriends'])->name('user.friends');
    Route::get('/user/suggestions',[UserController::class,'showSuggestions'])->name('user.suggestions');
    Route::post('/user/add/{user}',[UserController::class,'sendRequest'])->name('user.add');
    Route::get('/user/requests',[UserController::class,'showRequests'])->name('user.requests');
    Route::put('/request/accept/{request}',[RequestController::class,'acceptRequest'])->name('request.accept');
    Route::delete('/request/decline/{request}',[RequestController::class,'declineRequest'])->name('request.decline');
    Route::get('/messages/show/{user}',[MessageController::class,'showMessages'])->name('messages.show');
    Route::post('/messages/save/{user}',[MessageController::class,'saveMessage'])->name('messages.save');
    Route::get('/messages/new-messages/{user}',[MessageController::class,'getNewMessages'])->name('messages.get-new-messages');
});


