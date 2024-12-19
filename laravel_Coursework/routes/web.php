<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/',[HomeController::class,'homepage']);



route::get('/home',[HomeController::class,'index'])->name('home');

Route::get('/post_page',[AdminController::class,'post_page']);

Route::post('/add_post',[AdminController::class,'add_post']);
