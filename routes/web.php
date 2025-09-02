<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Головна сторінка
Route::get('/', function () {
    return view('welcome');
});

// Dashboard → показує стрічку постів
Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); // залишаємо dashboard, щоб не ламати Breeze/Jetstream

// Група роутів для авторизованих користувачів
Route::middleware(['auth'])->group(function () {

    // Створення поста
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Лайк поста
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

    // Профіль користувача
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth маршрути (login, register, forgot password)
require __DIR__.'/auth.php';
