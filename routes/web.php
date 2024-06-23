<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\EmotionScannerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chatgpt', [ChatGPTController::class, 'index'])->name('chatgpt.index');
Route::post('/chatgpt/ask', [ChatGPTController::class, 'ask'])->name('chatgpt.ask');
Route::get('/upload', [EmotionScannerController::class, 'index']);

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth', [FaceBookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});

Auth::routes([
    'verify' => false,
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');

Route::controller(TwitterController::class)->group(function () {
    Route::get('auth/twitter', 'redirectToTwitter')->name('auth.twitter');
    Route::get('auth/twitter/callback', 'handleTwitterCallback');
});

Route::get('/facebook/posts', [FaceBookController::class, 'fetchFacebookPosts'])->name('facebook.posts')->middleware('auth');
