<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

// Дашборд: всі пости
Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // CRUD для постів
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); 
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');         
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); 
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');  
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); 

    // Лайк/дизлайк (AJAX)
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

    // Коментарі
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');  
    Route::get('/comments/{comment}/edit', [PostController::class, 'editComment'])->name('comments.edit'); 
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])->name('comments.update'); 
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy'); 

    // Мої пости
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my');

    // Профіль поточного користувача
    Route::get('/profile', [ProfileController::class, 'showSelf'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Перегляд профілю будь-якого користувача
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.user.show');
});

require __DIR__.'/auth.php';
