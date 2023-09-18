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
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::name('cards.')->controller(CardController::class)->group(function () {
            Route::post('/cards', 'store')->name('store');
        });

        Route::name('merchants.')->controller(MerchantController::class)->group(function () {
            Route::get('/merchants', 'index')->name('index');
            Route::get('/merchants/{merchant}', 'show')->name('show');
        });

        Route::name('tasks.')->controller(TaskController::class)->group(function () {
            Route::post('/tasks', 'store')->name('store');
            Route::patch('/tasks/{task}/finish', 'finish')->name('finish');
            Route::patch('/tasks/{task}/fail', 'fail')->name('fail');
        });
    });
});
