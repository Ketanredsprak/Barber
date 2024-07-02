<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Customer\CustomerAccountController;


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

Route::get('/', function () {
    return redirect()->route('index');
});

Route::post('/language-change', [AdminController::class, 'languageChange'])->name('language.change');
Route::get('/index', [HomeController::class,'index'])->name('index');
Route::get('/about-us', [HomeController::class,'AboutUs'])->name('about-us');
Route::get('/contact-us', [HomeController::class,'contactUs'])->name('contact-us');
Route::post('/contact-submit', [HomeController::class,'contactSubmit'])->name('contact-submit');
Route::get('login', [CustomerAccountController::class, 'getLoginPage'])->name('login');
Route::post('customer-login', [CustomerAccountController::class, 'storeLogin'])->name('customer-login');
Route::get('register', [CustomerAccountController::class, 'register'])->name('register');
Route::post('register-submit', [CustomerAccountController::class, 'registerSubmit'])->name('register-submit');
Route::get('forgot-password', [CustomerAccountController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password-submit', [CustomerAccountController::class, 'forgotPasswordSubmit'])->name('forgot-password-submit');
Route::get('verify-otp/{id}', [CustomerAccountController::class, 'verifyOTP'])->name('verify-otp');
Route::post('verify-otp-submit', [CustomerAccountController::class, 'verifyOtpSubmit'])->name('verify-otp-submit');
Route::get('reset-password/{id}', [CustomerAccountController::class, 'resetPassword'])->name('reset-password');
Route::post('reset-password-submit', [CustomerAccountController::class, 'resetPasswordSubmit'])->name('reset-password-submit');
Route::get('/privacy-policy', [HomeController::class,'privacyPolicy'])->name('privacy-policy');
Route::get('/temrs-and-condition', [HomeController::class,'temrsAndCondition'])->name('temrs-and-condition');



Route::get('my-account', [CustomerAccountController::class, 'myAccount'])->name('my-account');
Route::post('edit-my-account', [CustomerAccountController::class, 'editMyAccount'])->name('edit-my-account');
Route::get('change-password', [CustomerAccountController::class, 'changePassword'])->name('change-password');
Route::post('change-password-submit', [CustomerAccountController::class, 'changePasswordSubmit'])->name('change-password-submit');






// Route::get('home', [AdminController::class, 'home'])->name('home');






require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
