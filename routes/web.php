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

    Route::get('role-permission', [RolePermissionController::class, 'index'])->name('role-permission');
    Route::get('role-permission/create', [RolePermissionController::class, 'create'])->name('role-permission.create');
    Route::post('role-permission/save', [RolePermissionController::class, 'store'])->name('role-permission.save');
    Route::delete('/role-permission/delete/{id}', [RolePermissionController::class, 'delete'])->name('role-permission.delete');
    Route::get('role-permission/edit/{id}', [RolePermissionController::class, 'edit'])->name('role-permission.edit');
    Route::post('role-permission/update', [RolePermissionController::class, 'update'])->name('role-permission.update');


    Route::get('user-management', [UserManagementContoller::class, 'index'])->name('user-management');
    Route::get('user-management/create', [UserManagementContoller::class, 'create'])->name('user-management.create');
    Route::get('user-management/edit/{id}', [UserManagementContoller::class, 'edit'])->name('user-management.edit');
    Route::post('user-management/save', [UserManagementContoller::class, 'store'])->name('user-management.save');
    Route::post('user-management/status', [UserManagementContoller::class, 'status'])->name('user-management.status');
    Route::get('user-management/profile/{id}', [UserManagementContoller::class, 'profile'])->name('user-management.profile');
    Route::post('user-management/update', [UserManagementContoller::class, 'update'])->name('user-management.update');

    Route::get('products', [ProductController::class, 'index'])->name('products');
});