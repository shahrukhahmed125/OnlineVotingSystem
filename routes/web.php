<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use Illuminate\Support\Facades\Route;

// ------- AUTH ROUTES ------- //

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/redirect/login', [AuthController::class, 'login_auth'])->name('login_auth');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/redirect/register',[AuthController::class,'register_auth'])->name('register_auth');


// ------- VOTER ROUTES ------- //

Route::middleware('auth', 'role:user')->group(function(){
    Route::prefix('voter-dashboard')->as('voter.')->group(function(){

        // ------- VOTER DASHBOARD ROUTES ------- //

        Route::controller(VoterController::class)->group(function(){
            Route::get('/', 'index')->name('home');
        });

    });
});

// ------- DASHBOARD ROUTES ------- //

Route::middleware('auth')->group(function(){
    Route::prefix('admin-dashboard')->as('admin.')->group(function(){

        // ------- ADMIN DASHBOARD ROUTES ------- //

        Route::controller(AdminController::class)->group(function(){
            Route::get('/', 'index')->name('home');
        });

        // ------- ASSEMBLY ROUTES ------- //

        Route::controller(AssemblyController::class)->group(function(){
            Route::prefix('assembly')->as('assembly.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
        });

    });
});

// Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('home');

Route::get('/candidates/create',[CandidateController::class, 'create'])->name('candidates.create');

Route::post('/candidates/store',[CandidateController::class, 'store'])->name('candidates.store');

Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
Route::get('/candidates/{id}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
Route::get('/candidates/edit/{id}', [CandidateController::class, 'edit'])->name('candidates.edit');
Route::post('/candidates/update/{id}', [CandidateController::class, 'update'])->name('candidates.update');