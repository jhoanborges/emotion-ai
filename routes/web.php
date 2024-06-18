<?php

use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [HomeController::class, 'index']);

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth', [FaceBookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::controller(TwitterController::class)->group(function () {
    Route::get('auth/twitter', 'redirectToTwitter')->name('auth.twitter');
    Route::get('auth/twitter/callback', 'handleTwitterCallback');
});
