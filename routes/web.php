<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

// Ana sayfa rotası
Route::get('/', function () {
    return view('welcome');
});

// Laravel Auth rotaları
Auth::routes();

// Özel logout rotası
Route::post('/logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Note rotaları (middleware ile korunmalı)
Route::middleware(['auth'])->group(function () {
    Route::resource('notes', App\Http\Controllers\NoteController::class);
});