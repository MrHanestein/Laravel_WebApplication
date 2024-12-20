<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

// Homepage Route
Route::get('/', [HomeController::class, 'homepage'])->name('homepage');

// Redirect /home to / for consistency
Route::get('/home', function () {
    return redirect()->route('homepage');
});

// Admin Routes (Protected by 'auth' middleware)
Route::middleware(['auth'])->group(function () {
    // Post Management
    Route::get('/post_page', [AdminController::class, 'post_page'])->name('post_page');
    Route::post('/add_post', [AdminController::class, 'add_post'])->name('add_post');
    Route::get('/show_post', [AdminController::class, 'show_post'])->name('show_post');
    Route::get('/delete_post/{id}', [AdminController::class, 'delete_post'])->name('delete_post');
    Route::get('/edit_page/{id}', [AdminController::class, 'edit_page'])->name('edit_page');
    Route::post('/update_post/{id}', [AdminController::class, 'update_post'])->name('update_post');

    // Create Post from Homepage
    Route::post('/create_post', [HomeController::class, 'createPost'])->name('create_post');

    // Comment Management
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}/update', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/{id}/delete', [CommentController::class, 'destroy'])->name('comments.delete');

    // Like/Unlike
    Route::post('/like', [LikeController::class, 'like'])->name('like');
    Route::post('/unlike', [LikeController::class, 'unlike'])->name('unlike');

    // User Profile
    Route::get('/profile/{id}', [HomeController::class, 'userProfile'])->name('user.profile');

    // Notifications
    Route::get('/notifications', [HomeController::class, 'showNotifications'])->name('notifications');
    Route::post('/mark_all_notifications_as_read', [HomeController::class, 'markAllNotificationsAsRead'])->name('mark_all_notifications_as_read');
});

// Dashboard Route (Protected by 'auth' and 'verified' middleware)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Post Details Route
Route::get('/post_details/{id}', [HomeController::class, 'post_details'])->name('post_details');

Route::get('/home', [HomeController::class, 'index'])->name('home');
