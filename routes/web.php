<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;


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
      return view('Frontend.home');
      return view('Frontend.under-development');
});


Route::get('admin/login', [AdminController::class, 'adminLogin'])->name('admin/login');
Route::post('admin-login', [AdminController::class, 'storeLogin'])->name('admin-login');
Route::post('/language-change', [AdminController::class, 'languageChange'])->name('language.change');


Route::get('home', [AdminController::class, 'home'])->name('home');






require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
