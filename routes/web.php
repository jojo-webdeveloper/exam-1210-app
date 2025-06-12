<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserTaskController;

Route::middleware('auth')->group(function () {
    Route::view('/', 'dashboard')->name('dashboard.home');
    Route::view('/dashboard', 'dashboard')->name('dashboard.main');
    Route::patch(
        'user_tasks/{user_task}/trash',
        [UserTaskController::class, 'trash']
    )->name('user_tasks.trash');
    Route::resource('user_tasks', UserTaskController::class);
});

Route::get('/register', [RegisterController::class, 'show'])->name('register'); 
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
