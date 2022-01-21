<?php

use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\CounterController;
use App\Http\Controllers\Api\Admin\ScheduleBusController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegController;
use App\Http\Controllers\Api\SuperAdmin\CompanyController;
use App\Http\Controllers\Api\SuperAdmin\DistrictController;
use App\Http\Controllers\Api\SuperAdmin\DivisionController;
use App\Http\Controllers\Api\SuperAdmin\UserController;
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
    Route::prefix('auth')->group(function () {
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegController::class, 'register']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout']);
        });

    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/companies', CompanyController::class);
        Route::apiResource('/company/{comapnyId}/users', UserController::class);
        Route::apiResource('/divisions', DivisionController::class);
        Route::apiResource('/divisions/{divisionId}/districts', DistrictController::class);
        Route::apiResource('/counters', CounterController::class);
        Route::apiResource('/buses', BusController::class);
        Route::apiResource('/schedulesbuses', ScheduleBusController::class);
    });
});
