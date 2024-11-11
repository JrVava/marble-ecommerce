<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserManagementContoller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    /**
     * User Management Route Start Here
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('role-permission/update', [RolePermissionController::class, 'update'])->name('role-permission.update');

    Route::prefix('role-permission')->name('role-permission.')->group(function () {
        Route::get('/list', [RolePermissionController::class, 'index'])->name('list');
        Route::get('/create', [RolePermissionController::class, 'create'])->name('create');
        Route::post('/save', [RolePermissionController::class, 'store'])->name('save');
        Route::delete('/delete/{id}', [RolePermissionController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [RolePermissionController::class, 'edit'])->name('edit');
        Route::post('/update', [RolePermissionController::class, 'update'])->name('update');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/list', [UserManagementContoller::class, 'index'])->name('list');
        Route::get('/create', [UserManagementContoller::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserManagementContoller::class, 'edit'])->name('edit');
        Route::post('/save', [UserManagementContoller::class, 'store'])->name('save');
        Route::post('status', [UserManagementContoller::class, 'status'])->name('status');
        Route::get('/profile/{id}', [UserManagementContoller::class, 'profile'])->name('profile');
        Route::post('/update', [UserManagementContoller::class, 'update'])->name('update');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index']); // Route name: products.index
        Route::get('create', [ProductController::class, 'create'])->name('create'); // Route name: products.new
    });
});