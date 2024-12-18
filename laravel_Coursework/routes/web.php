<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/',[HomeController::class,'homepage']);



route::get('/home',[HomeController::class,'index'])->name('home');
