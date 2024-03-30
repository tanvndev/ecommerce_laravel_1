<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\{
    LocationController,
    DashboardController as AjaxDashboardController
};
use App\Http\Controllers\Servers\{
    AuthController,
    DashboardController,
    GenerateController,
    LanguageController,
    PermissionController,
    UserController,
    UserCatalogueController,
    PostCatalogueController,
    PostController,
    ProductCatalogueController,
    GalleryCatalogueController,
//@@new-controller-module@@

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


Route::middleware(['admin', 'locale'])->group(function () {
    // Routes for Dashboard
    Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');


    // Routes for User
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    // Routes for UserCatalogue
    Route::prefix('user/catalogue')->name('user.catalogue.')->group(function () {
        Route::get('index', [UserCatalogueController::class, 'index'])->name('index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [UserCatalogueController::class, 'destroy'])->name('destroy');
        Route::get('permission', [UserCatalogueController::class, 'permission'])->name('permission');
        Route::put('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('updatePermission');
    });

    // Routes for Languages
    Route::prefix('language')->name('language.')->group(function () {
        Route::get('index', [LanguageController::class, 'index'])->name('index');
        Route::get('create', [LanguageController::class, 'create'])->name('create');
        Route::post('store', [LanguageController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [LanguageController::class, 'destroy'])->name('destroy');
        Route::get('{canonical}/switch', [LanguageController::class, 'switchServerLanguage'])->name('switch');
        Route::get('{id}/{languageId}/{model}/translate', [LanguageController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('translate');
        Route::put('{id}/handleTranslate', [LanguageController::class, 'handleTranslate'])->where(['id' => '[0-9]+'])->name('handleTranslate');
    });


    // Routes for Generate
    Route::prefix('generate')->name('generate.')->group(function () {
        Route::get('index', [GenerateController::class, 'index'])->name('index');
        Route::get('create', [GenerateController::class, 'create'])->name('create');
        Route::post('store', [GenerateController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [GenerateController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [GenerateController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [GenerateController::class, 'destroy'])->name('destroy');
    });


    // Routes for Permission
    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('index', [PermissionController::class, 'index'])->name('index');
        Route::get('create', [PermissionController::class, 'create'])->name('create');
        Route::post('store', [PermissionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [PermissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [PermissionController::class, 'destroy'])->name('destroy');
    });

    // Routes for Post
    Route::prefix('post')->name('post.')->group(function () {
        Route::get('index', [PostController::class, 'index'])->name('index');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [PostController::class, 'destroy'])->name('destroy');
    });



    // Routes for PostCatalogue
    Route::prefix('post/catalogue')->name('post.catalogue.')->group(function () {
        Route::get('index', [PostCatalogueController::class, 'index'])->name('index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [PostCatalogueController::class, 'destroy'])->name('destroy');
    });



    // Routes for ProductCatalogueController
    Route::prefix('product/catalogue')->name('product.catalogue.')->group(function () {
        Route::get('index', [ProductCatalogueController::class, 'index'])->name('index');
        Route::get('create', [ProductCatalogueController::class, 'create'])->name('create');
        Route::post('store', [ProductCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [ProductCatalogueController::class, 'destroy'])->name('destroy');
    });

    
    // Routes for GalleryCatalogueController
    Route::prefix('gallery/catalogue')->name('gallery.catalogue.')->group(function () {
        Route::get('index', [GalleryCatalogueController::class, 'index'])->name('index');
        Route::get('create', [GalleryCatalogueController::class, 'create'])->name('create');
        Route::post('store', [GalleryCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [GalleryCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [GalleryCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [GalleryCatalogueController::class, 'destroy'])->name('destroy');
    });
//@@new-route-module@@
    // Không xoá dòng comment này dùng để dịnh vị vị trí để thêm route tự động



    // Route for Ajax
    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.getLocation');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->middleware('admin')->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->middleware('admin')->name('ajax.dashboard.changeStatusAll');
});





Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('logged');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
