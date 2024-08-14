<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionPermissionController;
use App\Http\Controllers\Admin\SystemNotificationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebsiteConfigController;
use App\Http\Controllers\Admin\ReportController;

Route::get('admin/login', [AdminController::class, 'adminLogin'])->name('admin/login');
Route::post('admin-login', [AdminController::class, 'storeLogin'])->name('admin-login');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/profile', [AdminController::class, 'update'])->name('profile.update');
    Route::post('/getChangePassword', [AdminController::class, 'storeChangePassword'])->name('store.change.password');
    Route::get('/setting', [AdminController::class, 'setting'])->name('setting');

    // Our resource routes
    Route::resource('subadmin', SubAdminController::class);
    Route::get('subadmin-status/{id}', [SubAdminController::class, 'subadminStatus'])->name('subadmin.status');

    // Our resource routes
    Route::resource('user', UserController::class);
    Route::get('user-status/{id}', [UserController::class, 'userStatus'])->name('user.status');

    Route::resource('barber', BarberController::class);
    // Route::get('barber-status/{id}', [BarberController::class, 'barberStatus'])->name('barber.status');
    Route::get('barber-approved/{id}', [BarberController::class, 'barberApprovedStatus'])->name('barber.approved');
    Route::get('barber-suspend/{id}', [BarberController::class, 'barberSuspendStatus'])->name('barber.suspend');

    Route::resource('customer', CustomerController::class);
    // Route::get('customer-status/{id}', [CustomerController::class, 'customerStatus'])->name('customer.status');
    Route::get('customer-approved/{id}', [CustomerController::class, 'customerApprovedStatus'])->name('customer.approved');
    Route::get('customer-suspend/{id}', [CustomerController::class, 'customerSuspendStatus'])->name('customer.suspend');

    //   Route::resource('category', CategoryController::class);
    //   Route::get('category-status/{id}', [CategoryController::class, 'categoryStatus'])->name('category.status');

    Route::resource('country', CountryController::class);
    Route::get('country-status/{id}', [CountryController::class, 'countryStatus'])->name('country.status');

    Route::resource('state', StateController::class);
    Route::get('state-status/{id}', [StateController::class, 'stateStatus'])->name('state.status');
    Route::post('state-list', [StateController::class, 'listState'])->name('state.list');

    Route::resource('city', CityController::class);
    Route::get('city-status/{id}', [CityController::class, 'cityStatus'])->name('city.status');

    Route::resource('module', ModuleController::class);
    Route::get('module-status/{id}', [ModuleController::class, 'moduleStatus'])->name('module.status');

    Route::resource('permission', PermissionController::class);
    Route::get('permission-status/{id}', [PermissionController::class, 'permissionStatus'])->name('permission.status');

    Route::resource('role', RoleController::class);
    Route::get('role-status/{id}', [RoleController::class, 'roleStatus'])->name('role.status');

    Route::resource('cms', CmsController::class);
    Route::get('cms-status/{id}', [CmsController::class, 'cmsStatus'])->name('cms.status');
    Route::get('get-cms-content/{id}', [PermissionController::class, 'getCmsPageContent'])->name('cms.content');

    Route::resource('testimonial', TestimonialController::class);
    Route::get('testimonial-status/{id}', [TestimonialController::class, 'testimonialStatus'])->name('testimonial.status');

    Route::resource('banner', BannerController::class);
    Route::get('banner-status/{id}', [BannerController::class, 'bannerStatus'])->name('banner.status');

    Route::resource('service', ServiceController::class);
    Route::get('service-status/{id}', [ServiceController::class, 'serviceStatus'])->name('service.status');

    Route::resource('subject', SubjectController::class);
    Route::get('subject-status/{id}', [SubjectController::class, 'subjectStatus'])->name('subject.status');

    Route::resource('page', PageController::class);
    Route::get('page-status/{id}', [PageController::class, 'pageStatus'])->name('page.status');

    Route::get('get-website-config', [WebsiteConfigController::class, 'getWebsiteConfig'])->name('get-website-config');
    Route::post('website-config-update', [WebsiteConfigController::class, 'websiteConfigUpdate'])->name('website-config-update');
    Route::post('point-system-update', [WebsiteConfigController::class, 'pointSystemUpdate'])->name('point-system-update');

    Route::resource('contact-us', ContactUsController::class);
    Route::resource('subscription-permission', SubscriptionPermissionController::class);
    Route::post('/get.subscription.list', [SubscriptionPermissionController::class, 'getSubcriptions'])->name('get.subscription.list');

    Route::resource('subscription', SubscriptionController::class);
    Route::get('subscription-status/{id}', [SubscriptionController::class, 'subscriptionStatus'])->name('subscription.status');

    Route::resource('booking', BookingController::class);
    Route::get('booking-status/{id}', [SubscriptionController::class, 'bookingStatus'])->name('booking.status');

    Route::resource('SystemNotification', SystemNotificationController::class);
    // Route::resource('blog', BlogAndNewsController::class);
    // Route::get('blog-status/{id}', [BlogAndNewsController::class, 'blogStatus'])->name('blog.status');

    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

// Sub Admin
    Route::get('/subadmin-report', [ReportController::class, 'index'])->name('subadmin.report');
    Route::get('/subadmin-report-data', [ReportController::class, 'subadminReportData'])->name('subadmin.report.data');

// Customer
    Route::get('/customer-report', [ReportController::class, 'customerReport'])->name('customer.report');
    Route::get('/customer-report-data', [ReportController::class, 'customerReportData'])->name('customer.report.data');

// Barber
    Route::get('/barber-report', [ReportController::class, 'barberReport'])->name('barber.report');
    Route::get('/barber-report-data', [ReportController::class, 'barberReportData'])->name('barber.report.data');

// booking
    Route::get('/booking-report', [ReportController::class, 'bookingReport'])->name('booking.report');
    Route::get('/booking-report-data', [ReportController::class, 'bookingReportData'])->name('booking.report.data');

// revenue
    Route::get('/revenue-report', [ReportController::class, 'revenueReport'])->name('revenue.report');
    Route::get('/revenue-report-data', [ReportController::class, 'revenueReportData'])->name('revenue.report.data');

});
