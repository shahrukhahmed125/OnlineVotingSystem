<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\PoliticalPartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use App\Models\Vote;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ------- AUTH ROUTES ------- //

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/redirect/login', [AuthController::class, 'login_auth'])->name('login_auth');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/redirect/register',[AuthController::class,'register_auth'])->name('register_auth');

//----- TWO FACTOR AUTHENTICATION -----//

Route::get('/2fa/challenge', [TwoFactorController::class, 'show'])->name('2fa.challenge');
Route::post('/2fa/verify/{id}', [TwoFactorController::class, 'verify'])->name('2fa.verify');


// ------- VOTER ROUTES ------- //

// Route::middleware('auth', 'role:voter')->group(function(){
//     Route::prefix('voter-dashboard')->as('voter.')->group(function(){

//         // ------- VOTER DASHBOARD ROUTES ------- //

//         Route::controller(VoterController::class)->group(function(){
//             Route::get('/', 'index')->name('dashboard'); // Renamed from 'home'
//             Route::prefix('vote')->as('vote.')->group(function(){
//                 Route::get('/', 'create')->name('create');
//                 Route::post('/', 'store')->name('store');
//             });
//         });

//     });
// });

// ------- CANDIDATE / VOTER ROUTES ------- //

Route::middleware(['auth', 'role:candidate|voter'])->group(function () {
    Route::prefix('dashboard')->as('voter.')->group(function () {

        // ------- CANDIDATE/VOTER DASHBOARD ROUTES ------- //
        Route::controller(VoterController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/cast-vote', 'castVote')->name('castVote');
            Route::post('/cast-vote', 'storeVote')->name('storeVote');
        });

    });
});



// ------- DASHBOARD ROUTES ------- //

Route::middleware('auth', 'role:admin')->group(function(){
    Route::prefix('admin-dashboard')->as('admin.')->group(function(){

        // ------- ADMIN DASHBOARD ROUTES ------- //

        Route::controller(AdminController::class)->group(function(){
            Route::get('/', 'index')->name('home');
        });

        // ------- USER ROUTES ------- //

        Route::controller(UserController::class)->group(function(){
            Route::prefix('users')->as('users.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
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

        // ------- POLITICAL PARTY ROUTES ------- //

        Route::controller(PoliticalPartyController::class)->group(function(){
            Route::prefix('political-parties')->as('political_parties.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
        });

        // ------- CANDIDATE ROUTES ------- //

        Route::controller(CandidateController::class)->group(function(){
            Route::prefix('candidates')->as('candidates.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
        });

        // ------- Election ROUTES ------- //

        Route::controller(ElectionController::class)->group(function(){
            Route::prefix('elections')->as('elections.')->group(function(){
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