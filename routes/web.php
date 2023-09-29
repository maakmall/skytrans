<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestChangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/registration', 'registration');
    Route::post('/register', 'register');
    Route::get('/setting', 'setting');
    Route::put('/setting/{user}', 'updateProfile');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::get('daftar', 'registration');
    Route::post('daftar', 'register');
    Route::get('forgot-password', 'forgotPassword');
    Route::post('forgot-password', 'reset');
});

Route::prefix('requests')->controller(RequestChangeController::class)
    ->group(function() {
        Route::get('/', 'index');
        Route::get('/{requestChange}', 'show');
        Route::put('/{requestChange}/confirm', 'confirm');
});

Route::prefix('companies')->controller(CompanyController::class)
    ->group(function() {
        Route::get('/search', 'search');
        Route::post('/{companyId}/materials', 'addMaterial');
        Route::delete('/materials/{material}', 'deleteMaterial');
});

Route::get('deliveries/{delivery}/download', [DeliveryController::class, 'download']);
Route::get('materials/code/{code}', [MaterialController::class,'showByCode']);
Route::get('notifications', [NotificationController::class, 'index']);
Route::resource('deliveries', DeliveryController::class)->except('edit');
Route::resource('companies', CompanyController::class);
Route::resource('materials', MaterialController::class);
Route::resource('vehicles', VehicleController::class);
Route::resource('drivers', DriverController::class);
Route::resource('users', UserController::class);
