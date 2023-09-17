<?php

use App\Http\Controllers\Api\v1\CardController;
use App\Http\Controllers\Api\v1\MerchantController;
use App\Http\Controllers\Api\v1\TaskController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('v1.')->group(function () {
    Route::name('cards.')->controller(CardController::class)->group(function () {
        Route::post('/cards', 'store')->name('store');
    });

    Route::name('merchants.')->controller(MerchantController::class)->group(function () {
        Route::get('/merchants/{merchant}', 'show')->name('show');
    });

    Route::name('tasks.')->controller(TaskController::class)->group(function () {
        Route::post('/tasks', 'store')->name('store');
    });
});
