<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Servers\{
    AuthController,
    DashboardController,
    UserController
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
Route::get('/dashboard/index', [DashboardController::class, 'index'])->middleware('admin')->name('dashboard.index');

// Routes for User
Route::prefix('/user')->name('user.')->middleware('admin')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
});


// Route::post('/user/do-create', [UserController::class, 'create'])->middleware('admin')->name('user.index');
// Route::get('/user/update/{id}', [UserController::class, 'edit'])->middleware('admin')->name('user.edit');
// Route::post('/user/do-update/{id}', [UserController::class, 'update'])->middleware('admin')->name('user.update');



Route::get('/admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('logged');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
