<?php

use App\Http\Controllers\API\V1\AccountController;
use App\Http\Controllers\API\V1\Barber\BarberAccountController;
use App\Http\Controllers\API\V1\Barber\BarberBookingController;
use App\Http\Controllers\API\V1\Barber\BarberScheduleController;
use App\Http\Controllers\API\V1\Barber\LoyalClientController;
use App\Http\Controllers\API\V1\Barber\ReportController;
use App\Http\Controllers\API\V1\Barber\ServiceController;
use App\Http\Controllers\API\V1\Barber\SlotManagementController;
use App\Http\Controllers\API\V1\ChatModuleController;
use App\Http\Controllers\API\V1\Customer\BarberController;
use App\Http\Controllers\API\V1\Customer\BookingController;
use App\Http\Controllers\API\V1\Customer\CustomerAccountController;
use App\Http\Controllers\API\V1\Customer\MyFavoriteController;
use App\Http\Controllers\API\V1\GenralController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\SubscriptionController;
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
Route::get('/get-country-code', [GenralController::class, 'getCountryCode']);
Route::post('/get-page-content', [GenralController::class, 'getPageContent']);
Route::post('/get-login-content', [GenralController::class, 'getLoginContent']);
Route::get('/get-contact-us-subjects', [GenralController::class, 'getContactUsSubjects']);

Route::post('/social-login', [AccountController::class, 'socialLogin'])->name('social-login');
Route::post('/customer-register', [CustomerAccountController::class, 'customerRegister'])->name('customerRegister');
Route::post('/barber-register', [BarberAccountController::class, 'barberRegister'])->name('barberRegister');
Route::post('/login', [AccountController::class, 'login']);
Route::post('/forgot-password', [AccountController::class, 'forgotPassword']);
Route::post('/verify-otp', [AccountController::class, 'verifyOTP']);
Route::post('/reset-password', [AccountController::class, 'resetPassword']);

Route::get('language', [AccountController::class, 'language']);
Route::middleware('auth:api')->group(function () {
        Route::post('customer-dashboard', [CustomerAccountController::class, 'customerDashboard']);
        Route::post('barber-dashboard', [BarberAccountController::class, 'barberDashboard']);

    // subscription
        Route::post('get-all-subscriptions', [SubscriptionController::class, 'getAllSubscriptions']);
        Route::get('update-subscription/{id}', [SubscriptionController::class, 'updateSubscription']);

    //customer barber list and detail
        Route::post('get-all-barbers', [BarberController::class, 'getAllBarbers']);
    // Route::get('get-barber-detail/{id}', [BarberController::class, 'getBarberDetail']);
        Route::post('get-barber-detail', [BarberController::class, 'getBarberDetail']);
        Route::post('search-near-barber', [BarberController::class, 'searchNearBarber']);

    // contact us detail
        Route::get('contact-us-detail', [AccountController::class, 'contactUsDetail']);

    //account api
    Route::get('profile', [AccountController::class, 'profile']);
    Route::post('customer-edit-profile', [CustomerAccountController::class, 'customerEditProfile']);
    Route::post('barber-edit-profile', [BarberAccountController::class, 'barberEditProfile']);
    Route::post('change-password', [AccountController::class, 'changePassword']);
    Route::get('remove-image/{id}', [BarberAccountController::class, 'removeImage']);
    Route::post('logout', [AccountController::class, 'logout']);

    // barber
    Route::get('get-all-sub-services', [ServiceController::class, 'getAllSubServices']);
    Route::get('get-all-sub-services-without-pagination', [ServiceController::class, 'getAllSubServicesWithoutPagination']);
    Route::get('get-all-services', [ServiceController::class, 'getAllServices']);
    Route::post('add-and-update-services', [ServiceController::class, 'addAndUpdateServices']);
    Route::get('get-barber-provide-services', [ServiceController::class, 'getBarberProvideServices']);
    Route::get('delete-service-from-barber/{id}', [ServiceController::class, 'deleteServiceFromBarber']);

    // schedule
    Route::post('add-and-update-barber-schedule', [BarberScheduleController::class, 'addAndUpdateBarberSchedule']);

    // notification
    Route::get('get-all-notification', [NotificationController::class, 'getAllNotification']);

    // favorite
    Route::get('get-all-my-favorites', [MyFavoriteController::class, 'getAllMyFavorites']);
    Route::post('add-and-remove-favorite', [MyFavoriteController::class, 'addAndRemoveFavorite']);

    //contact us submit
    Route::post('contact-us-submit', [AccountController::class, 'contactUsSubmit']);

    //chat module
    Route::post('get-my-chat-list', [ChatModuleController::class, 'getMyChatList']);
    Route::post('send-message', [ChatModuleController::class, 'sendMessage']);
    Route::post('get-one-to-one-chat', [ChatModuleController::class, 'getOneToOneChat']);

    //customer
    Route::post('booking', [BookingController::class, 'booking']);
    Route::post('booking-with-join-waitlist', [BookingController::class, 'bookingWithJoinWaitlist']);
    Route::post('join-waitlist', [BookingController::class, 'joinWaitlist']);
    Route::get('cancel-booking/{id}', [BookingController::class, 'cancelBooking']);
    Route::get('reschedule-booking/{id}', [BookingController::class, 'rescheduleBooking']);
    Route::post('reschedule-booking-submit', [BookingController::class, 'rescheduleBookingSubmit']);

    //barber
    Route::post('get-all-barber-appointments', [BarberBookingController::class, 'getAllBarberAppointments']);
    Route::get('get-barber-appointment-detail/{id}', [BarberBookingController::class, 'getBarberAppointmentDetail']);
    // wait list
    Route::post('direct-accept-waitlist', [BarberBookingController::class, 'directAcceptWaitlist']);
    Route::post('accept-or-reject-customer-appointment', [BarberBookingController::class, 'acceptOrRejectCustomerAppointment']);
    Route::post('accept-or-reject-customer-with-join-waitlist-appointment', [BarberBookingController::class, 'acceptOrRejectCustomerWithJoinWaitlistAppointment']);

    Route::post('barber-booking-list', [BookingController::class, 'barberBookingList']);
    Route::get('get-barber-all-loyal-client-list', [LoyalClientController::class, 'getBarberAllLoyalClientList']);
    Route::post('barber-send-notification-to-loyal-client', [LoyalClientController::class, 'barberSendNotificationToLoyalClient']);
    Route::post('report', [ReportController::class, 'report']);
    Route::post('/report-generate-excel', [ReportController::class, 'generateExcel']);

    //barber slot management
    Route::post('enable-or-disable-barber-slot', [SlotManagementController::class, 'enableOrDisableBarberSlot']);
    Route::post('enable-or-disable-barber-slot-v1', [SlotManagementController::class, 'enableOrDisableBarberSlotV1']);
    Route::post('get-disable-slot-list', [SlotManagementController::class, 'getDisableSlotList']);
    Route::post('enable-or-disable-barber-slot-date-range', [SlotManagementController::class, 'enableOrDisableBarberSlotDateRange']);

    //customer
    Route::post('get-all-customer-appointments', [BookingController::class, 'getAllCustomerAppointments']);
    Route::post('get-customer-appointment-detail', [BookingController::class, 'getCustomerAppointmentDetail']);
    Route::post('accept-or-reject-barber-proposal', [BookingController::class, 'acceptOrRejectBarberProposal']);
    Route::post('rating-barber', [BookingController::class, 'ratingBarber']);
    Route::get('booking-invoice/{id}', [BookingController::class, 'bookingInvoice']);

    //both
    Route::post('notification-on-or-off', [NotificationController::class, 'notificationOnOrOff']);
    Route::get('my-point', [AccountController::class, 'myPoints']);

});
