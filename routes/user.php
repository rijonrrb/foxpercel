<?php

use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\AlarmController as StaffAlarmController;
use App\Http\Controllers\Staff\DefconLevelController as StaffDefconLevelController;
use App\Http\Controllers\Staff\UserDashboardController as StaffUserDashboardController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\AlarmController;
use App\Http\Controllers\User\DefconLevelController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\UserDashboardController;


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


Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth', 'check.parent_user', '2fa:user']], function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('profile-update', [UserDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password-update', [UserDashboardController::class, 'passwordUpdate'])->name('password.update');

    Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('create', [StaffController::class, 'create'])->name('create');
        Route::post('store', [StaffController::class, 'store'])->name('store');
        Route::get('edit/{id?}', [StaffController::class, 'edit'])->name('edit');
        Route::get('view/{id?}', [StaffController::class, 'view'])->name('view');
        Route::post('update/{id?}', [StaffController::class, 'update'])->name('update');
        Route::get('delete/{id?}', [StaffController::class, 'delete'])->name('delete');
    });

    // alarm
    Route::group(['prefix' => 'alarm', 'as' => 'alarm.'], function () {
        Route::get('/', [AlarmController::class, 'index'])->name('index');
        Route::get('/create', [AlarmController::class, 'create'])->name('create');
        Route::post('/store', [AlarmController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AlarmController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AlarmController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AlarmController::class, 'delete'])->name('delete');
        Route::post('/sort', [AlarmController::class, 'sort'])->name('sort');
    });

    // notification
    Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::post('/store', [NotificationController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [NotificationController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [NotificationController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [NotificationController::class, 'delete'])->name('delete');
    });
    // alarm level
    Route::group(['prefix' => 'defcon-level', 'as' => 'defcon-level.'], function () {
        Route::get('/', [DefconLevelController::class, 'index'])->name('index');
        Route::get('/create', [DefconLevelController::class, 'create'])->name('create');
        Route::post('/store', [DefconLevelController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DefconLevelController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DefconLevelController::class, 'update'])->name('update');
        Route::post('/make-default', [DefconLevelController::class, 'makeDefault'])->name('make-default');
        Route::get('/delete/{id}', [DefconLevelController::class, 'delete'])->name('delete');
        Route::post('/sort', [DefconLevelController::class, 'sort'])->name('sort');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/store', [SettingsController::class, 'store'])->name('store');
    });

});

Route::group(['as' => 'staff.', 'prefix' => 'staff', 'middleware' => ['auth', 'check.staff_user', '2fa:user']], function () {

    Route::get('/dashboard', [StaffUserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [StaffUserDashboardController::class, 'profile'])->name('profile');
    Route::post('profile-update', [StaffUserDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password-update', [StaffUserDashboardController::class, 'passwordUpdate'])->name('password.update');

    // alarm
    Route::group(['prefix' => 'alarm', 'as' => 'alarm.'], function () {
        Route::get('/', [StaffAlarmController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [StaffAlarmController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StaffAlarmController::class, 'update'])->name('update');
    });

    // alarm level
    Route::group(['prefix' => 'defcon-level', 'as' => 'defcon-level.'], function () {
        Route::get('/', [StaffDefconLevelController::class, 'index'])->name('index');
        Route::post('/make-default', [StaffDefconLevelController::class, 'makeDefault'])->name('make-default');
    });

});

Route::get('auth/{provider}', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'handleGoogleCallback']);
