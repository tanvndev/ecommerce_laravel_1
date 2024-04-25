<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\{
    LocationController,
    DashboardController as AjaxDashboardController,
    AttributeController as AjaxAttributeController,
    MenuController as AjaxMenuController,
    SlideController as AjaxSlideController,
    ProductController as AjaxProductController,
    SourceController as AjaxSourceController,
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
    ProductController,
    AttributeCatalogueController,
    AttributeController,
    SystemController,
    MenuController,
    SlideController,
    WidgetController,
    PromotionController,
    SourceController,
    CustomerController,
    CustomerCatalogueController,
    //@@new-controller-module@@

};

use App\Http\Controllers\Clients\{
    HomeController
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


// CLIENT ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');


// SERVER ROUTES

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

    // Routes for System
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('index', [SystemController::class, 'index'])->name('index');
        Route::post('store', [SystemController::class, 'store'])->name('store');
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


    // Routes for ProductController
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Routes for AttributeCatalogueController
    Route::prefix('attribute/catalogue')->name('attribute.catalogue.')->group(function () {
        Route::get('index', [AttributeCatalogueController::class, 'index'])->name('index');
        Route::get('create', [AttributeCatalogueController::class, 'create'])->name('create');
        Route::post('store', [AttributeCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AttributeCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [AttributeCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [AttributeCatalogueController::class, 'destroy'])->name('destroy');
    });

    // Routes for AttributeController
    Route::prefix('attribute')->name('attribute.')->group(function () {
        Route::get('index', [AttributeController::class, 'index'])->name('index');
        Route::get('create', [AttributeController::class, 'create'])->name('create');
        Route::post('store', [AttributeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [AttributeController::class, 'destroy'])->name('destroy');
    });

    // Routes for MenuController
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('index', [MenuController::class, 'index'])->name('index');
        Route::get('create', [MenuController::class, 'create'])->name('create');
        Route::post('store', [MenuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::get('/{id}/editMenu', [MenuController::class, 'editMenu'])->where(['id' => '[0-9]+'])->name('editMenu');
        Route::put('/{id}/update', [MenuController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [MenuController::class, 'destroy'])->name('destroy');
        Route::get('{id}/children', [MenuController::class, 'children'])->name('children');
        Route::put('{id}/saveChildren', [MenuController::class, 'saveChildren'])->name('save.children');
        Route::get('{id}/{languageId}/translate', [MenuController::class, 'translate'])->where(['languageId' => '[0-9]+', 'id' => '[0-9]+'])->name('translate');
        Route::put('{languageId}/saveTranslate', [MenuController::class, 'saveTranslate'])->where(['languageId' => '[0-9]+'])->name('save.translate');
    });

    // Routes for SlideController
    Route::prefix('slide')->name('slide.')->group(function () {
        Route::get('index', [SlideController::class, 'index'])->name('index');
        Route::get('create', [SlideController::class, 'create'])->name('create');
        Route::post('store', [SlideController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SlideController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [SlideController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [SlideController::class, 'destroy'])->name('destroy');
    });

    // Routes for WidgetController
    Route::prefix('widget')->name('widget.')->group(function () {
        Route::get('index', [WidgetController::class, 'index'])->name('index');
        Route::get('create', [WidgetController::class, 'create'])->name('create');
        Route::post('store', [WidgetController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [WidgetController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [WidgetController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [WidgetController::class, 'destroy'])->name('destroy');
        Route::get('{id}/{languageId}/translate', [WidgetController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('translate');
        Route::put('saveTranslate', [WidgetController::class, 'saveTranslate'])->name('saveTranslate');
    });

    // Routes for PromotionController
    Route::prefix('promotion')->name('promotion.')->group(function () {
        Route::get('index', [PromotionController::class, 'index'])->name('index');
        Route::get('create', [PromotionController::class, 'create'])->name('create');
        Route::post('store', [PromotionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PromotionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [PromotionController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [PromotionController::class, 'destroy'])->name('destroy');
    });

    // Routes for SourceController
    Route::prefix('source')->name('source.')->group(function () {
        Route::get('index', [SourceController::class, 'index'])->name('index');
        Route::get('create', [SourceController::class, 'create'])->name('create');
        Route::post('store', [SourceController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SourceController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [SourceController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [SourceController::class, 'destroy'])->name('destroy');
    });

    // Routes for CustomerController
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('index', [CustomerController::class, 'index'])->name('index');
        Route::get('create', [CustomerController::class, 'create'])->name('create');
        Route::post('store', [CustomerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [CustomerController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Routes for CustomerCatalogueController
    Route::prefix('customer/catalogue')->name('customer.catalogue.')->group(function () {
        Route::get('index', [CustomerCatalogueController::class, 'index'])->name('index');
        Route::get('create', [CustomerCatalogueController::class, 'create'])->name('create');
        Route::post('store', [CustomerCatalogueController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CustomerCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
        Route::put('/{id}/update', [CustomerCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
        Route::delete('destroy', [CustomerCatalogueController::class, 'destroy'])->name('destroy');
    });
    //@@new-route-module@@
    // Không xoá dòng comment này dùng để dịnh vị vị trí để thêm route tự động



    // Route for Ajax
    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.getLocation');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->middleware('admin')->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->middleware('admin')->name('ajax.dashboard.changeStatusAll');
    Route::get('ajax/dashboard/getMenu', [AjaxDashboardController::class, 'getMenu'])->middleware('admin')->name('ajax.dashboard.getMenu');
    Route::get('ajax/dashboard/findModelObject', [AjaxDashboardController::class, 'findModelObject'])->middleware('admin')->name('ajax.dashboard.findModelObject');
    Route::get('ajax/dashboard/findPromotionObject', [AjaxDashboardController::class, 'findPromotionObject'])->middleware('admin')->name('ajax.dashboard.findPromotionObject');
    Route::get('ajax/dashboard/getPromotionConditionValue', [AjaxDashboardController::class, 'getPromotionConditionValue'])->middleware('admin')->name('ajax.dashboard.getPromotionConditionValue');
    Route::get('ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->middleware('admin')->name('ajax.attribute.getAttribute');
    Route::get('ajax/attribute/loadAttribute', [AjaxAttributeController::class, 'loadAttribute'])->middleware('admin')->name('ajax.attribute.loadAttribute');
    Route::post('ajax/menu/createCatalogue', [AjaxMenuController::class, 'createCatalogue'])->middleware('admin')->name('ajax.menu.createCatalogue');
    Route::post('ajax/menu/drag', [AjaxMenuController::class, 'drag'])->middleware('admin')->name('ajax.menu.drag');
    Route::put('ajax/slide/drag', [AjaxSlideController::class, 'drag'])->middleware('admin')->name('ajax.slide.drag');
    Route::get('ajax/product/loadProductPromotion', [AjaxProductController::class, 'loadProductPromotion'])->middleware('admin')->name('ajax.slide.loadProductPromotion');
    Route::get('ajax/source/getAllSource', [AjaxSourceController::class, 'getAllSource'])->middleware('admin')->name('ajax.source.getAllSource');
});





Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('logged');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
