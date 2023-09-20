<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CardController;
use App\Http\Controllers\Api\v1\MerchantController;
use App\Http\Controllers\Api\v1\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->name('v1.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('users')->name('users.')->controller(TaskController::class)->group(function () {
            Route::get('/{user}/tasks/finished', 'finished')->name('tasks.finished');
        });

        Route::prefix('cards')->name('cards.')->controller(CardController::class)->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::prefix('merchants')->name('merchants.')->controller(MerchantController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{merchant}', 'show')->name('show');
            Route::post('/', 'store')->name('store');
        });

        Route::prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
            Route::post('/', 'store')->name('store');
            Route::patch('/{task}/finish', 'finish')->name('finish');
            Route::patch('/{task}/fail', 'fail')->name('fail');
        });
    });
});
