<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\GenralController;
use App\Http\Controllers\API\V1\AccountController;
use App\Http\Controllers\API\V1\Barber\ServiceController;

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
Route::get('/get-country-code',[GenralController::class, 'getCountryCode']);



Route::post('/social-login',[AccountController::class, 'socialLogin'])->name('social-login');
Route::post('/customer-register',[AccountController::class, 'customerRegister'])->name('customerRegister');
Route::post('/barber-register',[AccountController::class, 'barberRegister'])->name('barberRegister');
Route::post('/login',[AccountController::class, 'login']);
Route::post('/forgot-password',[AccountController::class, 'forgotPassword']);
Route::post('/verify-otp', [AccountController::class, 'verifyOTP']);
Route::post('/reset-password', [AccountController::class, 'resetPassword']);


Route::get('language',[AccountController::class, 'language']);
Route::middleware('auth:api')->group(function () {

    //account api
    Route::get('profile',[AccountController::class, 'profile']);
    Route::post('customer-edit-profile',[AccountController::class, 'customerEditProfile']);
    Route::post('barber-edit-profile',[AccountController::class, 'barberEditProfile']);
    Route::post('change-password',[AccountController::class, 'changePassword']);
    Route::post('logout',[AccountController::class, 'logout']);

    // barber
    Route::get('get-all-services',[ServiceController::class, 'getAllServices']);
    Route::post('add-and-update-services',[ServiceController::class, 'addAndUpdateServices']);

});
