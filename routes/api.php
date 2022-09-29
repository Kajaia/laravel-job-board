<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\JobVacancy\JobVacancyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/vacancy', [JobVacancyController::class, 'vacancies']);
    Route::get('/vacancy/{id}', [JobVacancyController::class, 'vacancy']);

    Route::middleware('guest')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/vacancy', [JobVacancyController::class, 'addVacancy']);
        Route::put('/vacancy/{id}', [JobVacancyController::class, 'updateVacancy']);
        Route::delete('/vacancy/{id}', [JobVacancyController::class, 'deleteVacancy']);
        Route::post('/vacancy/{id}/response', [JobVacancyController::class, 'sendResponse']);
        Route::delete('/vacancy/{id}/response', [JobVacancyController::class, 'deleteResponse']);
        Route::post('/vacancy/{id}/like', [JobVacancyController::class, 'likeVacancy']);
        Route::post('/user/{id}/like', [AuthController::class, 'likeUser']);
        Route::get('/liked/vacancies', [JobVacancyController::class, 'likedVacancies']);
    });
});
