<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
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
Route::get('users', [UserController::class, 'getUsers'])->name('getUsers');
Route::get('contacts', [UserController::class, 'getContacts'])->name('getContacts');
Route::get('groups', [UserController::class, 'getGroups'])->name('getGroups');

Route::get('users/{id}', [UserController::class, 'getUserByID'])->name('getUserByID');
Route::post('user/remove', [UserController::class, 'userRemove'])->name('userRemove');

Route::get('contacts/{id}', [UserController::class, 'getContactByID'])->name('getContactByID');
Route::post('contact/remove', [UserController::class, 'contactRemove'])->name('contactRemove');

Route::get('groups/{id}', [UserController::class, 'getGroupByID'])->name('getGroupByID');
Route::post('group/remove', [UserController::class, 'groupRemove'])->name('groupRemove');

Route::post('email/template/store', [EmailController::class, 'emailTemplateStore'])->name('emailTemplateStore');
Route::post('email/send', [EmailController::class, 'sendMail'])->name('sendMail');
Route::get('get/mail/{uid}', [EmailController::class, 'getEmailByUid'])->name('getEmailByUid');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
