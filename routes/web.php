<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ------- AUTH ROUTES ------- //

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');


// ------- ADMIN DASHBOARD ROUTES ------- //

Route::get('/home', [UserController::class, 'index'])->name('home');

Route::get('/candidates/create',[CandidateController::class, 'create'])->name('candidates.create');

Route::post('/candidates/store',[CandidateController::class, 'store'])->name('candidates.store');