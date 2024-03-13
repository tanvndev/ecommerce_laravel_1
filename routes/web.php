<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\{
    LocationController,
    DashboardController as AjaxDashboardController
};
use App\Http\Controllers\Servers\{
    AuthController,
    DashboardController,
    UserController,
    UserCatalogueController
};


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




// Routes for Admin
Route::get('dashboard/index', [DashboardController::class, 'index'])->middleware('admin')->name('dashboard.index');

// Routes for User
Route::prefix('user')->name('user.')->middleware('admin')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
});

// Routes for UserCatalogue
Route::prefix('user/catalogue')->name('user.catalogue.')->middleware('admin')->group(function () {
    Route::get('index', [UserCatalogueController::class, 'index'])->name('index');
    Route::get('create', [UserCatalogueController::class, 'create'])->name('create');
    Route::post('store', [UserCatalogueController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::put('/{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::delete('destroy', [UserCatalogueController::class, 'destroy'])->name('destroy');
});


// Route for Ajax
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->middleware('admin')->name('ajax.location.getLocation');
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->middleware('admin')->name('ajax.dashboard.changeStatus');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->middleware('admin')->name('ajax.dashboard.changeStatusAll');


// Route::post('/user/do-create', [UserController::class, 'create'])->middleware('admin')->name('user.index');
// Route::get('/user/update/{id}', [UserController::class, 'edit'])->middleware('admin')->name('user.edit');
// Route::post('/user/do-update/{id}', [UserController::class, 'update'])->middleware('admin')->name('user.update');



Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('logged');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
