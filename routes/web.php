<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia('App');
}); 



Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');

});