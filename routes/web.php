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
use Illuminate\Support\Facades\Route;

//-------- WELCOME ROUTE ------ //

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


// ------- CANDIDATE / VOTER ROUTES ------- //

Route::middleware(['auth', 'role:candidate|voter'])->group(function () {
    Route::prefix('dashboard')->as('voter.')->group(function () {

        // ------- CANDIDATE/VOTER DASHBOARD ROUTES ------- //
        Route::controller(VoterController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/cast-vote', 'castVote')->name('castVote');
            Route::post('/store-vote', 'storeVote')->name('storeVote');
        });

    });
});



// ------- DASHBOARD ROUTES ------- //

Route::middleware('auth', 'role:admin')->group(function(){
    Route::prefix('admin-dashboard')->as('admin.')->group(function(){

        // ------- ADMIN DASHBOARD ROUTES ------- //

        Route::controller(AdminController::class)->group(function(){
            Route::get('/', 'index')->name('home');
            Route::get('/votes', 'getVotes')->name('votes.index');
            Route::delete('/votes/{id}', 'deleteVote')->name('votes.destroy');
            Route::get('/top-candidates', 'topCandidates')->name('votes.top_candidates');
            Route::get('/votes-by-party', 'viewVotesByParty')->name('votes.by_party');
            Route::post('/votes-by-party', 'getVotesByParty')->name('votes.by_party');
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
                Route::post('/assign/{id}', 'assign')->name('assign');
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