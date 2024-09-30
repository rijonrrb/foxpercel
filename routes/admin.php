<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Models\BlogCategory;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\MailController;

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

Route::get('admin/2fa', [TwoFactorController::class, 'show2faForm'])->name('admin.2fa');
Route::get('admin/2fa-enable', [TwoFactorController::class, 'enable2fa'])->name('admin.2fa.enabled');
Route::post('admin/2fa/verify', [TwoFactorController::class, 'verify2fa'])->name('admin.2fa.verify');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:admin'], 'where' => ['locale' => '[a-zA-Z]{2}']], function () {


    Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@dashboard']);
    Route::get('/cc', 'DashboardController@cacheClear')->name('cacheClear');
    Route::get('settings', ['as' => 'settings', 'uses' => 'SettingsController@settings']);


    //Custom Page
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('general', 'SettingsController@general')->name('general');
        Route::post('general/store', 'SettingsController@generalStore')->name('general_store');
        Route::get('languages','LanguageController@index')->name('language');
        Route::post('language/store','LanguageController@store')->name('language.store');
        Route::get('language/{id}/edit','LanguageController@edit')->name('language.edit');
        Route::post('language/{id}/update','LanguageController@update')->name('language.update');
        Route::get('language/{id}/delete','LanguageController@delete')->name('language.delete');
        Route::get('backup','SettingsController@backup')->name('backup');
        Route::get('download/database','SettingsController@backupDB')->name('download.database');
        Route::get('download/project','SettingsController@backupProject')->name('download.project');
        Route::post('schedule/backup','SettingsController@scheduleBackupStore')->name('schedule.backup');
    });

    


    Route::get('ajax/text-editor/image', ['as' => 'text-editor.image', 'uses' => 'CustomPageController@postEditorImageUpload']);
    //Custom Page
    Route::group(['prefix' => 'cpage', 'as' => 'cpage.'], function () {
        Route::get('/', 'CustomPageController@index')->name('index');
        Route::get('create', 'CustomPageController@create')->name('create');
        Route::post('store', 'CustomPageController@store')->name('store');
        Route::get('{id}/view', 'CustomPageController@view')->name('view');
        Route::get('{id}/edit', 'CustomPageController@edit')->name('edit');
        Route::post('{id}/update', 'CustomPageController@update')->name('update');
        Route::get('{id}/delete', 'CustomPageController@getDelete')->name('delete');
    });


    //Faq
    Route::group(['prefix' => 'faq', 'as' => 'faq.'], function () {
        Route::get('/', 'FaqController@index')->name('index');
        Route::get('create', 'FaqController@create')->name('create');
        Route::post('store', 'FaqController@store')->name('store');
        Route::get('{id}/view', 'FaqController@view')->name('view');
        Route::get('{id}/edit', 'FaqController@edit')->name('edit');
        Route::post('{id}/update', 'FaqController@update')->name('update');
        Route::get('{id}/delete', 'FaqController@delete')->name('delete');
    });




    // Setting
    Route::get('pages', 'SettingsController@pages')->name('pages');
    Route::get('page/{home}', 'SettingsController@editHomePage')->name('edit.home');
    Route::post('page/{home}/update', 'SettingsController@updateHomePage')->name('update.home');

    Route::get('settings', 'SettingsController@settings')->name('settings');
    Route::post('change-settings', 'SettingsController@changeSettings')->name('change.settings');
    Route::get('tax-setting', 'SettingsController@taxSetting')->name('tax.setting');
    Route::post('update-tex-setting', 'SettingsController@updateTaxSetting')->name('update.tax.setting');
    Route::post('update-email-setting', 'SettingsController@updateEmailSetting')->name('update.email.setting');
    Route::get('test-email', 'SettingsController@testEmail')->name('test.email');


    Route::get('edit-user/{id}', 'UserController@editUser')->name('edit.user');
    Route::post('update-user', 'UserController@updateUser')->name('update.user');
    Route::get('view-user/{id}', 'UserController@viewUser')->name('view.user');
    Route::get('change-user-plan/{id}', 'UserController@ChangeUserPlan')->name('change.user.plan');
    Route::post('update-user-plan', 'UserController@UpdateUserPlan')->name('update.user.plan');
    Route::get('update-status', 'UserController@updateStatus')->name('update.status');
    Route::get('active-user/{id}', 'UserController@activeStatus')->name('update.active-user');
    Route::get('delete-user', 'UserController@deleteUser')->name('delete.user');
    Route::get('login-as/{id}', 'UserController@authAs')->name('login-as.user');
    Route::get('user/trash-list', 'UserController@getTrashList')->name('user.trash-list');


    // Customers
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::get('/', 'CustomerController@index')->name('index');
        Route::get('create', 'CustomerController@create')->name('create');
        Route::post('store', 'CustomerController@store')->name('store');
        Route::get('{id}/edit', 'CustomerController@edit')->name('edit');
        Route::post('{id}/update', 'CustomerController@update')->name('update');
        Route::get('{id}/view', 'CustomerController@view')->name('view');
        Route::get('{id}/delete', 'CustomerController@delete')->name('delete');
        Route::get('{id}/staff', 'CustomerController@staff')->name('staff');
        Route::get('{id}/login', 'CustomerController@authAs')->name('login');
    });

    // staff
    Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
        Route::get('/', 'StaffController@index')->name('index');
        Route::get('create', 'StaffController@create')->name('create');
        Route::post('store', 'StaffController@store')->name('store');
        Route::get('edit/{id?}', 'StaffController@edit')->name('edit');
        Route::get('view/{id?}', 'StaffController@view')->name('view');
        Route::post('update/{id?}', 'StaffController@update')->name('update');
        Route::get('delete/{id?}', 'StaffController@delete')->name('delete');
        Route::get('{id}/login', 'StaffController@authAs')->name('login');

    });


    // location
    Route::group(['prefix' => 'locations', 'as' => 'location.'], function () {
        Route::get('/', 'LocationController@index')->name('index');
        Route::get('create', 'LocationController@create')->name('create');
        Route::post('store', 'LocationController@store')->name('store');
        Route::get('edit/{slug}', 'LocationController@edit')->name('edit');
        Route::post('update/{slug}', 'LocationController@update')->name('update');
        Route::get('delete', 'LocationController@delete')->name('delete');
    });


    // investment
    Route::group(['prefix' => 'investments', 'as' => 'investment.'], function () {
        Route::get('/', 'InvestmentController@index')->name('index');
        Route::get('create', 'InvestmentController@create')->name('create');
        Route::post('store', 'InvestmentController@store')->name('store');
        Route::get('edit/{slug}', 'InvestmentController@edit')->name('edit');
        Route::post('update/{slug}', 'InvestmentController@update')->name('update');
        Route::get('delete', 'InvestmentController@delete')->name('delete');
    });

    // admin profile
    Route::get('profile', [DashboardController::class, 'adminProfile'])->name('profile');
    Route::post('profile-update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password-update', [DashboardController::class, 'passwordUpdate'])->name('password.update');

    // franchises list
    Route::get('franchises', 'FranchisesController@index')->name('franchises.index');
    Route::get('franchise/create', 'FranchisesController@create')->name('franchises.create');
    Route::post('franchise/store', 'FranchisesController@store')->name('franchises.store');
    Route::get('franchise/{slug}/edit', 'FranchisesController@edit')->name('franchises.edit');
    Route::post('franchise/{slug}/update', 'FranchisesController@update')->name('franchises.update');
    Route::get('franchise/view/{slug}', 'FranchisesController@view')->name('franchises.view');
    Route::get('franchise/delete/{id}', 'FranchisesController@delete')->name('franchises.delete');


     //Category
     Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::post('/store', 'CategoryController@store')->name('store');
        Route::get('/{id}/edit', 'CategoryController@edit')->name('edit');
        Route::post('/{id}/update', 'CategoryController@update')->name('update');
        Route::get('/{id}/delete', 'CategoryController@delete')->name('delete');
    });

    //SubCategory
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
        Route::get('/', 'SubCategoryController@index')->name('index');
        Route::post('/store', 'SubCategoryController@store')->name('store');
        Route::get('/{id}/edit', 'SubCategoryController@edit')->name('edit');
        Route::post('/{id}/update', 'SubCategoryController@update')->name('update');
        Route::get('/{id}/delete', 'SubCategoryController@delete')->name('delete');
    });


    //Blog Category
    Route::group(['prefix' => 'blog-category', 'as' => 'blog-category.'], function () {
        Route::get('/', 'BlogCategoryController@index')->name('index');
        Route::post('/store', 'BlogCategoryController@store')->name('store');
        Route::get('/{id}/edit', 'BlogCategoryController@edit')->name('edit');
        Route::post('/{id}/update', 'BlogCategoryController@update')->name('update');
        Route::get('/{id}/delete', 'BlogCategoryController@delete')->name('delete');
    });

    //Blog Post
    Route::group(['prefix' => 'blog-post', 'as' => 'blog-post.'], function () {
        Route::get('/', 'BlogPostController@index')->name('index');
        Route::get('create', 'BlogPostController@create')->name('create');
        Route::post('store', 'BlogPostController@store')->name('store');
        Route::get('{id}/edit', 'BlogPostController@edit')->name('edit');
        Route::post('{id}/update', 'BlogPostController@update')->name('update');
        Route::get('{id}/view', 'BlogPostController@view')->name('view');
        Route::get('{id}/delete', 'BlogPostController@delete')->name('delete');
    });

    //Contact
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::get('/', 'ContactController@index')->name('index');
        Route::get('create', 'ContactController@create')->name('create');
        Route::post('store', 'ContactController@store')->name('store');
        Route::get('{id}/edit', 'ContactController@edit')->name('edit');
        Route::post('{id}/update', 'ContactController@update')->name('update');
        Route::get('{id}/view', 'ContactController@view')->name('view');
        Route::get('{id}/delete', 'ContactController@delete')->name('delete');
    });


    //Country
    Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::get('create', [CountryController::class, 'create'])->name('create');
        Route::post('store', [CountryController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CountryController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [CountryController::class, 'update'])->name('update');
        Route::get('{id}/delete', [CountryController::class, 'delete'])->name('delete');
    });

    //Region
    Route::group(['prefix' => 'region', 'as' => 'region.'], function () {
        Route::get('/', 'RegionController@index')->name('index');
        Route::get('create', 'RegionController@create')->name('create');
        Route::post('store', 'RegionController@store')->name('store');
        Route::get('{id}/edit', 'RegionController@edit')->name('edit');
        Route::post('{id}/update', 'RegionController@update')->name('update');
        // Route::get('{id}/view', 'RegionController@view')->name('view');
        Route::get('{id}/delete', 'RegionController@delete')->name('delete');
    });

    //City
    Route::group(['prefix' => 'city', 'as' => 'city.'], function () {
        Route::get('/', 'CityController@index')->name('index');
        Route::get('create', 'CityController@create')->name('create');
        Route::post('store', 'CityController@store')->name('store');
        Route::get('{id}/edit', 'CityController@edit')->name('edit');
        Route::post('{id}/update', 'CityController@update')->name('update');
        Route::get('{id}/view', 'CityController@view')->name('view');
        Route::get('{id}/delete', 'CityController@delete')->name('delete');
        Route::get('country/region/{countryId?}', 'CityController@CountryWiseRegion')->name('countrywise.region');
    });

    // // notification
    // Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    //     Route::get('/', 'NotificationController@index')->name('index');
    //     Route::get('/create', 'NotificationController@create')->name('create');
    //     Route::post('/store', 'NotificationController@store')->name('store');
    //     Route::get('/edit/{id}', 'NotificationController@edit')->name('edit');
    //     Route::post('/update/{id}', 'NotificationController@update')->name('update');
    //     Route::get('/delete/{id}', 'NotificationController@delete')->name('delete');
    // });

    //  // alarm
    //  Route::group(['prefix' => 'alarm', 'as' => 'alarm.'], function () {
    //     Route::get('/', 'AlarmController@index')->name('index');
    //     Route::get('/create', 'AlarmController@create')->name('create');
    //     Route::post('/store', 'AlarmController@store')->name('store');
    //     Route::get('/edit/{id}', 'AlarmController@edit')->name('edit');
    //     Route::post('/update/{id}', 'AlarmController@update')->name('update');
    //     Route::get('/delete/{id}', 'AlarmController@delete')->name('delete');
    // });


    // // alarm level
    // Route::group(['prefix' => 'defcon-level', 'as' => 'defcon-level.'], function () {
    //     Route::get('/', 'DefconLevelController@index')->name('index');
    //     Route::get('/create', 'DefconLevelController@create')->name('create');
    //     Route::post('/store', 'DefconLevelController@store')->name('store');
    //     Route::get('/edit/{id}', 'DefconLevelController@edit')->name('edit');
    //     Route::post('/update/{id}', 'DefconLevelController@update')->name('update');
    //     Route::get('/delete/{id}', 'DefconLevelController@delete')->name('delete');
    //     Route::get('/{id}/make-default', 'DefconLevelController@makeDefault')->name('make-default');

    // });




});
