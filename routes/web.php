<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.atm.atm');
});

Route::group(['prefix' => 'atm'], function () {
    Route::get('/auth', function () {
        return view('pages.atm.auth');
    });
    Route::get('/bri', function () {
        return view('pages.atm.bri');
    });
    Route::get('/bni', function () {
        return view('pages.atm.bni');
    });
    Route::get('/bca', function () {
        return view('pages.atm.bca');
    });
});

Route::group(['prefix' => 'process'], function () {
    Route::get('/get-trx/{account_number}', [TransactionController::class, 'getTrx']);
    Route::post('/set-trx', [TransactionController::class, 'setTrx']);
    Route::post('/auth', [AccountController::class, 'auth']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
