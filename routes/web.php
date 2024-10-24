<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Cron\BookingCronController;
use App\Http\Controllers\Front\MyFavoriteController;
use App\Http\Controllers\Auth\AppleSocialAuthController;
use App\Http\Controllers\Auth\GoogleSocialAuthController;
use App\Http\Controllers\Front\Customer\BookingController;
use App\Http\Controllers\Front\Customer\ChatModuleController;
use App\Http\Controllers\Front\Customer\CustomerAccountController;


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

Route::get('/admin', function () {
    return redirect()->route('admin/login');
});


Route::get('/send-test-mail', [HomeController::class, 'sendTestMail'])->name('send-test-mail');
Route::post('/language-change', [AdminController::class, 'languageChange'])->name('language.change');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/about-us', [HomeController::class, 'AboutUs'])->name('about-us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contact-submit', [HomeController::class, 'contactSubmit'])->name('contact-submit');
Route::get('login', [CustomerAccountController::class, 'getLoginPage'])->name('login');
Route::post('customer-login', [CustomerAccountController::class, 'storeLogin'])->name('customer-login');
Route::get('verify/{id}', [CustomerAccountController::class, 'verify'])->name('verify');
Route::post('verify-submit', [CustomerAccountController::class, 'verifySubmit'])->name('verify-submit');
Route::get('register', [CustomerAccountController::class, 'register'])->name('register');
Route::post('register-submit', [CustomerAccountController::class, 'registerSubmit'])->name('register-submit');
Route::get('forgot-password', [CustomerAccountController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password-submit', [CustomerAccountController::class, 'forgotPasswordSubmit'])->name('forgot-password-submit');
Route::post('otp-resend-forgot-password', [CustomerAccountController::class, 'otpResendForgotPassword'])->name('otp-resend-forgot-password');
Route::get('verify-otp/{id}', [CustomerAccountController::class, 'verifyOTP'])->name('verify-otp');
Route::post('verify-otp-submit', [CustomerAccountController::class, 'verifyOtpSubmit'])->name('verify-otp-submit');
Route::get('reset-password/{id}', [CustomerAccountController::class, 'resetPassword'])->name('reset-password');
Route::post('reset-password-submit', [CustomerAccountController::class, 'resetPasswordSubmit'])->name('reset-password-submit');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-condition', [HomeController::class, 'termsAndCondition'])->name('terms-and-condition');
Route::get('/barber-list', [HomeController::class, 'barberList'])->name('barber-list');
Route::post('/barber-list-filter', [HomeController::class, 'barberListFilter'])->name('barber-list-filter');
Route::get('barber-detail/{id}', [HomeController::class, 'barberDetail'])->name('barber-detail');
Route::get('get-cms-content/{id}', [HomeController::class, 'getCmsContent'])->name('get-cms-content');
Route::post('nearest-barber-list', [HomeController::class, 'nearestBarberList'])->name('nearest-barber-list');
Route::post('rating-barber-list', [HomeController::class, 'ratingBarberList'])->name('rating-barber-list');
Route::get('services', [HomeController::class, 'services'])->name('services');



Route::get('google', [GoogleSocialAuthController::class, 'redirectToGoogle'])->name('google');
Route::get('google/callback', [GoogleSocialAuthController::class, 'GoogleLoginCallback']);

Route::get('login/apple', [AppleSocialAuthController::class, 'redirectToApple'])->name('login.apple');
Route::get('auth/apple/callback', [AppleSocialAuthController::class, 'handleAppleCallback']);


Route::middleware('webauth')->group(function () {

    Route::get('notification-list', [CustomerAccountController::class, 'notificationList'])->name('notification-list');
    Route::get('my-account', [CustomerAccountController::class, 'myAccount'])->name('my-account');
    Route::get('my-account-about', [CustomerAccountController::class, 'myAccountAbout'])->name('my-account-about');
    Route::get('my-package', [CustomerAccountController::class, 'myPackage'])->name('my-package');
    Route::get('my-chat', [ChatModuleController::class, 'myChat'])->name('my-chat');
    Route::post('chat-list', [ChatModuleController::class, 'chatList'])->name('chat-list');
    Route::get('/get-chat/{id}', [ChatModuleController::class, 'getChat'])->name('get-chat');
    Route::post('/send-message', [ChatModuleController::class, 'sendMessage'])->name('send.message');
    Route::post('edit-my-account', [CustomerAccountController::class, 'editMyAccount'])->name('edit-my-account');
    Route::get('change-password', [CustomerAccountController::class, 'changePassword'])->name('change-password');
    Route::post('change-password-submit', [CustomerAccountController::class, 'changePasswordSubmit'])->name('change-password-submit');
    Route::get('my-point', [CustomerAccountController::class, 'myPoint'])->name('my-point');
    Route::get('add-and-remove-favorite/{id}', [MyFavoriteController::class, 'addAndRemoveFavorite'])->name('add-and-remove-favorite');
    Route::get('my-favorite', [MyFavoriteController::class, 'myFavoriteList'])->name('my-favorite');
    Route::get('my-booking-appointment-today', [BookingController::class, 'myBookingAppointmentToday'])->name('my-booking-appointment-today');
    Route::get('my-booking-appointment-history', [BookingController::class, 'myBookingAppointmentHistory'])->name('my-booking-appointment-history');
    Route::get('my-booking-appointment-detail/{id}', [BookingController::class, 'myBookingAppointmentDetail'])->name('my-booking-appointment-detail');
    Route::get('my-booking-appointment-success/{id}', [BookingController::class, 'myBookingAppointmentSuccess'])->name('my-booking-appointment-success');
    Route::get('reject-barber-proposal/{id}', [BookingController::class, 'rejectBarberProposal'])->name('reject-barber-proposal');
    Route::get('accept-barber-proposal/{id}', [BookingController::class, 'acceptBarberProposal'])->name('accept-barber-proposal');
    Route::get('update-package/{id}', [CustomerAccountController::class, 'updatePackage'])->name('update-package');

//booking
    Route::post('booking', [BookingController::class, 'booking'])->name('booking');
    Route::post('get-barber-slots', [BookingController::class, 'getBarberSlots'])->name('get-barber-slots');
    Route::post('get-barber-slots-reshedule', [BookingController::class, 'getBarberSlotsReshedule'])->name('get-barber-slots-reshedule');
    Route::get('get-booking-page/{id}', [BookingController::class, 'getBookingPage'])->name('get-booking-page');
    Route::get('get-join-waitlist/{id}', [BookingController::class, 'getJoinWaitlist'])->name('get-join-waitlist');
    Route::post('booking-join-waitlist', [BookingController::class, 'bookingJoinWaitlist'])->name('booking-join-waitlist');
    Route::post('join-waitlist', [BookingController::class, 'joinWaitlist'])->name('join-waitlist');
    Route::get('get-booking-detail/{id}', [BookingController::class, 'getBookingDetail'])->name('get-booking-detail');
    Route::get('cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancel-booking');
    Route::get('reschedule-booking/{id}', [BookingController::class, 'rescheduleBooking'])->name('reschedule-booking');
    Route::post('reschedule-booking-submit', [BookingController::class, 'rescheduleBookingSubmit'])->name('reschedule-booking-submit');
    Route::post('rating-submit', [BookingController::class, 'ratingSubmit'])->name('rating-submit');
    Route::get('booking-invoice/{id}', [BookingController::class, 'bookingInvoice'])->name('booking-invoice');

});

//cron job
Route::get('/booking-finished', [BookingCronController::class, 'bookingFinished']);
Route::get('/cancel-pending-booking', [BookingCronController::class, 'cancelPendingBooking']);
Route::get('/notification-demo', [BookingCronController::class, 'notificationDemo']);
Route::get('demo-pdf', [HomeController::class, 'demoPdf']);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
