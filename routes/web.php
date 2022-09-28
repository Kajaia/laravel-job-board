<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\JobVacancy\JobVacancyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function() {
    Route::view('/', 'welcome')->name('home');

    Route::name('auth.')->group(function() {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });
});

Route::middleware('auth')->group(function() {
    Route::post('/vacancy', [JobVacancyController::class, 'addVacancy'])->name('vacancy.store');
    Route::post('/vacancy/{id}/response', [JobVacancyController::class, 'sendResponse'])->name('vacancy.store.response');
});
