<?php

use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\Staff\AlarmController as StaffAlarmController;
use App\Http\Controllers\Staff\DefconLevelController as StaffDefconLevelController;
use App\Http\Controllers\Staff\UserDashboardController as StaffUserDashboardController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\AlarmController;
use App\Http\Controllers\User\DefconLevelController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\TwoFactorController;
use App\Http\Controllers\User\UserDashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


Route::get('/cc', [HomeController::class, 'cc'])->name('cc');
Auth::routes();

// Route::get('auth/{provider}', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/{provider}/callback', [SocialLoginController::class, 'handleGoogleCallback']);

// Route::get('/2fa', [TwoFactorController::class, 'show2faForm'])->name('2fa');
// Route::get('/2fa-enable', [TwoFactorController::class, 'enable2fa'])->name('2fa.enabled');
// Route::post('/2fa/verify', [TwoFactorController::class, 'verify2fa'])->name('2fa.verify');
Route::get('/otp-verification', [OtpController::class, 'otpForm'])->name('otp.verification');

Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('profile-update', [UserDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password-update', [UserDashboardController::class, 'passwordUpdate'])->name('password.update');


    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/store', [SettingsController::class, 'store'])->name('store');
    });

});

