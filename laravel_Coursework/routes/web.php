<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/',[HomeController::class,'homepage']);



Route::get('/home',[HomeController::class,'index'])->name('home');


Route::post('/add_post',[AdminController::class,'add_post']);

Route::get('/post_page',[AdminController::class,'post_page']);

Route::get('/show_post',[AdminController::class,'show_post']);

Route::get('/delete_post/{id}',[AdminController::class,'delete_post']);
