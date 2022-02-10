<?php

use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\BusControllerGET;
use App\Http\Controllers\Api\Admin\CounterController;
use App\Http\Controllers\Api\Admin\CounterControllerGET;
use App\Http\Controllers\Api\Admin\DriverController;
use App\Http\Controllers\Api\Admin\ScheduleBusController;
use App\Http\Controllers\Api\Admin\ScheduleBusControllerGET;
use App\Http\Controllers\Api\Admin\StaffController;
use App\Http\Controllers\Api\Auth\ForgetPassController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegController;
use App\Http\Controllers\Api\Helper\HelperController;
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
        Route::post('/forget', [ForgetPassController::class, 'forget']);
        Route::post('/confirm', [ForgetPassController::class, 'confirm']);
        Route::patch('/resend', [ForgetPassController::class, 'resend']);
        Route::patch('/changePass', [ForgetPassController::class, 'changePass']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout']);
        });

    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/file', [HelperController::class, 'fileUploader']);

        //Super-Admin
        Route::apiResource('/companies', CompanyController::class);
        Route::post('/company-search', [CompanyController::class, 'search']);
        Route::apiResource('/company/{companyId}/users', UserController::class);
        Route::post('/company/{companyId}/user-search', [UserController::class, 'search']);
        Route::patch('/company/{companyId}/users/suspend/{id}', [UserController::class, 'suspend']);
        Route::apiResource('/divisions', DivisionController::class);
        Route::apiResource('/divisions/{divisionId}/districts', DistrictController::class);

        //Admin
        Route::apiResource('/counters', CounterController::class);
        Route::apiResource('/counters-get', CounterControllerGET::class);
        Route::post('/counters-search', [CounterController::class, 'search']);
        Route::apiResource('/buses', BusController::class);
        Route::apiResource('/buses-get', BusControllerGET::class);
        Route::apiResource('/schedulesbuses', ScheduleBusController::class);
        Route::apiResource('/schedulesbuses-get', ScheduleBusControllerGET::class);
        Route::apiResource('/drivers', DriverController::class);
        Route::apiResource('/staffs', StaffController::class);
    });
});
