<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ------- AUTH ROUTES ------- //

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');


// ------- ADMIN DASHBOARD ROUTES ------- //

Route::get('/home', [UserController::class, 'index'])->name('home');