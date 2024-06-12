<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main Page Route
// ->middleware('auth')
Route::get('login', [AuthenticationController::class, 'login_cover'])->name('login');
Route::get('authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate');

/* Route Dashboards */
// Route::group(['prefix' => 'dashboard'], function () {
// Route::get('analytics', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
//     Route::get('ecommerce', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');
// });
/* Route Dashboards */
//Route::middleware(['auth'])->group(function () {
Route::get('/', [EmailController::class, 'getNewEmails'])->name('getNewEmails');
Route::get('get/seen/emails', [EmailController::class, 'seenEmails'])->name('seenEmails');
Route::get('get/deleted/emails', [EmailController::class, 'deletedEmails'])->name('deletedEmails');

Route::get('users', [UserController::class, 'index'])->name('index');
Route::post('users/store', [UserController::class, 'userStore'])->name('userStore');
Route::post('contact/store', [UserController::class, 'contactStore'])->name('contactStore');
Route::get('contacts', [UserController::class, 'contactList'])->name('contactList');
Route::post('group/store', [UserController::class, 'groupStore'])->name('groupStore');
Route::get('groups', [UserController::class, 'groupList'])->name('groupList');
Route::get('logout', [AuthenticationController::class, 'destroy']);
Route::get('/ckbox/token', [AuthenticationController::class, 'token'])->name('ckbox_token');
Route::get('/email/temp', [UserController::class, 'emailTemplate'])->name('emailTemplate');


//});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
