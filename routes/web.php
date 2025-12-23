<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebuiController;

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_action'])->name('login.post')->middleware('throttle:10,5');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(VerifyCsrfToken::class);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_action'])->name('register.post')->middleware('throttle:10,5');
});

Route::prefix('API')->name('api.')->withoutMiddleware(VerifyCsrfToken::class)->group(function () {
    Route::post('/connect', [ApiController::class, 'Authenticate'])->name('connect')->middleware('throttle:25,5');
});

Route::middleware('auth', 'session.timeout', 'no.cache')->group(function () {
    Route::get('/', [DashController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/data', [DashController::class, 'licensedata_10'])->name('dashboard.data');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::post('/', [UserController::class, 'manageusersedit_action'])->where('id', '[0-9a-fA-F-]{36}')->name('edit.post');
            Route::post('/generate', [UserController::class, 'manageusersgenerate_action'])->name('generate.post');
            Route::post('/delete', [UserController::class, 'manageusersdelete'])->name('delete');
            Route::post('/wallet', [UserController::class, 'manageuserssaldoedit_action'])->name('wallet.post');
        });

        Route::prefix('referrables')->name('referrable.')->group(function () {
            Route::get('/data', [DashController::class, 'managereferrabledata'])->name('data');

            Route::post('/update', [DashController::class, 'managereferrableedit_action'])->name('edit.post');
            Route::post('/generate', [DashController::class, 'managereferrablegenerate_action'])->name('generate.post');
            Route::post('/delete', [DashController::class, 'managereferrabledelete'])->name('delete');
        });
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('/username-change', [SettingController::class, 'settingsusername'])->name('username');
        Route::post('/name-change', [SettingController::class, 'settingsname'])->name('name');
        Route::post('/password-change', [SettingController::class, 'settingspassword'])->name('password');

        Route::prefix('webui')->name('webui.')->group(function () {
            Route::post('/', [WebuiController::class, 'webui_action'])->name('update');
        });
    });

    Route::prefix('apps')->name('apps.')->group(function () {
        Route::get('/data', [AppController::class, 'appdata'])->name('data');

        Route::post('/update', [AppController::class, 'appedit_action'])->name('edit.post');
        Route::post('/delete', [AppController::class, 'appdelete'])->name('delete');
        Route::post('/delete/licenses', [AppController::class, 'appdeletelicenses'])->name('delete.licenses');
        Route::post('/delete/licenses/user-only', [AppController::class, 'appdeletelicensesme'])->name('delete.licenses.me');
        Route::post('/generate', [AppController::class, 'appgenerate_action'])->name('generate.post');
    });

    Route::prefix('licenses')->name('licenses.')->group(function () {
        Route::get('/resetApiKey/{id?}', [LicenseController::class, 'licenseresetapi'])->where('id', '[0-9a-fA-F-]{36}')->name('resetApiKey');

        Route::post('/update', [LicenseController::class, 'licenseedit_action'])->name('edit.post');
        Route::post('/delete', [LicenseController::class, 'licensedelete'])->name('delete');
        Route::post('/generate', [LicenseController::class, 'licensegenerate_action'])->name('generate.post');
    });
});

Route::fallback(function () {return view('errors.fallback');});