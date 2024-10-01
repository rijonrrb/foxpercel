<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SettingsController;

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

//====================Admin Authentication=========================
Route::get('admin', function () {
    return redirect()->route('login.admin');
});

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login.admin');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

//====================Admin Routes=========================
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/cc', [DashboardController::class, 'cacheClear'])->name('cacheClear');

    // Admin Profile
    Route::get('profile', [DashboardController::class, 'adminProfile'])->name('profile');
    Route::post('profile-update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password-update', [DashboardController::class, 'passwordUpdate'])->name('password.update');

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('general', [SettingsController::class, 'general'])->name('general');
        Route::post('general/store', [SettingsController::class, 'generalStore'])->name('general_store');
        Route::get('backup', [SettingsController::class, 'backup'])->name('backup');
        Route::get('download/database', [SettingsController::class, 'backupDB'])->name('download.database');
        Route::post('schedule/backup', [SettingsController::class, 'scheduleBackupStore'])->name('schedule.backup');
        Route::get('test-email', [SettingsController::class, 'testEmail'])->name('test.email');
    });

    // Languages
    Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
        Route::get('/', [LanguageController::class, 'index'])->name('index');
        Route::post('store', [LanguageController::class, 'store'])->name('store');
        Route::get('{id}/edit', [LanguageController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [LanguageController::class, 'update'])->name('update');
        Route::get('{id}/delete', [LanguageController::class, 'delete'])->name('delete');
    });

    // Custom Pages
    Route::group(['prefix' => 'cpage', 'as' => 'cpage.'], function () {
        Route::get('/', [CustomPageController::class, 'index'])->name('index');
        Route::get('create', [CustomPageController::class, 'create'])->name('create');
        Route::post('store', [CustomPageController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CustomPageController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [CustomPageController::class, 'update'])->name('update');
        Route::get('{id}/delete', [CustomPageController::class, 'getDelete'])->name('delete');
    });

    // Customers
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('create', [CustomerController::class, 'create'])->name('create');
        Route::post('store', [CustomerController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [CustomerController::class, 'update'])->name('update');
        Route::get('{id}/view', [CustomerController::class, 'view'])->name('view');
        Route::get('{id}/delete', [CustomerController::class, 'delete'])->name('delete');
    });

    // Locations
    Route::group(['prefix' => 'locations', 'as' => 'location.'], function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('create', [LocationController::class, 'create'])->name('create');
        Route::post('store', [LocationController::class, 'store'])->name('store');
        Route::get('{slug}/edit', [LocationController::class, 'edit'])->name('edit');
        Route::post('{slug}/update', [LocationController::class, 'update'])->name('update');
        Route::get('delete', [LocationController::class, 'delete'])->name('delete');
    });


    // Contacts
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('create', [ContactController::class, 'create'])->name('create');
        Route::post('store', [ContactController::class, 'store'])->name('store');
        Route::get('{id}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [ContactController::class, 'update'])->name('update');
        Route::get('{id}/view', [ContactController::class, 'view'])->name('view');
        Route::get('{id}/delete', [ContactController::class, 'delete'])->name('delete');
    });

    // Country
    Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::get('create', [CountryController::class, 'create'])->name('create');
        Route::post('store', [CountryController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CountryController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [CountryController::class, 'update'])->name('update');
        Route::get('{id}/delete', [CountryController::class, 'delete'])->name('delete');
    });

    // Region
    Route::group(['prefix' => 'region', 'as' => 'region.'], function () {
        Route::get('/', [RegionController::class, 'index'])->name('index');
        Route::get('create', [RegionController::class, 'create'])->name('create');
        Route::post('store', [RegionController::class, 'store'])->name('store');
        Route::get('{id}/edit', [RegionController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [RegionController::class, 'update'])->name('update');
        Route::get('{id}/delete', [RegionController::class, 'delete'])->name('delete');
    });

    // City
    Route::group(['prefix' => 'city', 'as' => 'city.'], function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::get('create', [CityController::class, 'create'])->name('create');
        Route::post('store', [CityController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CityController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [CityController::class, 'update'])->name('update');
        Route::get('{id}/delete', [CityController::class, 'delete'])->name('delete');
        Route::get('country/region/{countryId?}', [CityController::class, 'CountryWiseRegion'])->name('countrywise.region');
    });
});
