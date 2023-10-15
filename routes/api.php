<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\TransportController;

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

Route::prefix('manufacturers')->name('manufacturers.')->group(function () {
    Route::get('/', [ManufacturerController::class, 'index'])->name('index');
    Route::post('/', [ManufacturerController::class, 'store'])->name('store');
    Route::patch('/{manufacturer}', [ManufacturerController::class, 'update'])->name('update');
    Route::delete('/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('destroy');

    Route::get('/models', [ModelController::class, 'all'])->name('allModels');
    Route::get('/{manufacturer}', [ManufacturerController::class, 'show'])->name('show');

    Route::prefix('/{manufacturer}/models')->name('models.')->group(function () {
        Route::get('/', [ModelController::class, 'index'])->name('index');
        Route::post('/', [ModelController::class, 'store'])->name('store');
        Route::get('/{model}', [ModelController::class, 'show'])->name('show');
        Route::patch('/{model}', [ModelController::class, 'update'])->name('update');
        Route::delete('/{model}', [ModelController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('/transports')->name('transports.')->group(function () {
    Route::get('/', [TransportController::class, 'index'])->name('index');
    Route::post('/', [TransportController::class, 'store'])->name('store');
    Route::get('/{transport}', [TransportController::class, 'show'])->name('show');
    Route::patch('/{transport}', [TransportController::class, 'update'])->name('update');
    Route::delete('/{transport}', [TransportController::class, 'destroy'])->name('destroy');
});
