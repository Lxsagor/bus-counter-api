<?php

use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\CounterController;
use App\Http\Controllers\Api\Admin\DriverController;
use App\Http\Controllers\Api\Admin\FareController;
use App\Http\Controllers\Api\Admin\ScheduleBusController;
use App\Http\Controllers\Api\Admin\StaffController;
use App\Http\Controllers\Api\Admin\TrackController;
use App\Http\Controllers\Api\Auth\ForgetPassController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegController;
use App\Http\Controllers\Api\Counter\BookingController;
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
            Route::get('/me', [LoginController::class, 'me']);
        });

    });

    Route::middleware('auth:sanctum')->group(function () {

        //Super-Admin
        Route::apiResource('/companies', CompanyController::class);
        Route::post('/company-search', [CompanyController::class, 'search']);
        Route::apiResource('/company/{companyId}/users', UserController::class);
        Route::post('/company/{companyId}/user-search', [UserController::class, 'search']);
        Route::patch('/company/{companyId}/users/suspend/{id}', [UserController::class, 'suspend']);

        //Admin
        Route::apiResource('/counters', CounterController::class);
        Route::get('/counters-get', [CounterController::class, 'get']);
        Route::post('/counters-search', [CounterController::class, 'search']);
        Route::apiResource('/buses', BusController::class);
        Route::get('/buses-get', [BusController::class, 'get']);
        Route::get('/buses-by-type/{type}', [BusController::class, 'getBusByType']);
        Route::apiResource('/schedulesbuses', ScheduleBusController::class);
        Route::post('/schedulesbuses-search', [ScheduleBusController::class, 'search']);
        Route::get('/schedulesbuses-get', [ScheduleBusController::class, 'get']);
        Route::apiResource('/fares', FareController::class);
        Route::apiResource('/drivers', DriverController::class);
        Route::get('/staffs-get', [StaffController::class, 'get']);
        Route::get('/drivers-get', [DriverController::class, 'get']);

        Route::apiResource('/staffs', StaffController::class);
        Route::apiResource('/tracks', TrackController::class);

        //Counter
        Route::post('/counter/route-search', [BookingController::class, 'routeSearch']);
        Route::get('/counter/routes', [BookingController::class, 'allroutes']);
        Route::post('/counter/assignBus', [BookingController::class, 'assignBus']);
        Route::post('/counter/ticketBooking', [BookingController::class, 'ticketBooking']);

    });

    Route::post('/file-uploader', [HelperController::class, 'fileUploader']);
    Route::apiResource('/divisions', DivisionController::class);
    Route::apiResource('/divisions/{divisionId}/districts', DistrictController::class);
    Route::get('/districts', [DistrictController::class, 'districts']);
});