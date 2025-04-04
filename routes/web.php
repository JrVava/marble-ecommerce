<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPreviewController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ModeratorManagementController;

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


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Role & Permission Route Start Here
     */
    Route::prefix('role-permission')->name('role-permission.')->group(function () {
        Route::get('/list', [RolePermissionController::class, 'index'])->name('list');
        Route::get('/create', [RolePermissionController::class, 'create'])->name('create');
        Route::post('/save', [RolePermissionController::class, 'store'])->name('save');
        Route::delete('/delete/{id}', [RolePermissionController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [RolePermissionController::class, 'edit'])->name('edit');
        Route::post('/update', [RolePermissionController::class, 'update'])->name('update');
    });
    /**
     * Role & Permission Route End Here
     */

    /**
     * User Management Route Start Here
     */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/list', [UserManagementController::class, 'index'])->name('list');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
        Route::post('/save', [UserManagementController::class, 'store'])->name('save');
        Route::post('status', [UserManagementController::class, 'status'])->name('status');
        Route::get('/profile/{id}', [UserManagementController::class, 'profile'])->name('profile');
        Route::post('/update', [UserManagementController::class, 'update'])->name('update');

        Route::get('/delete/{id}', [UserManagementController::class, 'delete'])->name('delete');
    });
    /**
     * User Management Route End Here
     */

    /**
     * Products Route End Here
     */
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('list');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('get-products');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('save', [ProductController::class, 'store'])->name('save');
        Route::delete('delete/{product_id}', [ProductController::class, 'delete'])->name('delete');
        Route::get('edit/{product_id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update', [ProductController::class, 'update'])->name('update');
        Route::get('qrcode/{product_id}', [ProductController::class, 'showQRCode'])->name('qrcode');
    });
    /**
     * Products Route End Here
     */

    Route::get('moderator-management', [ModeratorManagementController::class, 'index'])->name('moderator-management');
    Route::get('moderator-management/create', [ModeratorManagementController::class, 'create'])->name('moderator-management.create');
    Route::post('moderator-management/save', [ModeratorManagementController::class, 'store'])->name('moderator-management.save');
    Route::get('moderator-management/edit/{id}', [ModeratorManagementController::class, 'edit'])->name('moderator-management.edit');
    Route::delete('/moderator-management/delete/{id}', [ModeratorManagementController::class, 'delete'])->name('moderator-management.delete');
    Route::post('moderator-management/update', [ModeratorManagementController::class, 'update'])->name('moderator-management.update');

    Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');

    Route::prefix('preview-product')->name('preview-product.')->group(function () {
        Route::get('/all-products', [ProductPreviewController::class, 'getAllProducts'])->name('all-products');
        Route::get('/{product_id}', [ProductPreviewController::class, 'index'])->name('index');
        Route::post('/send-product-pdf', [ProductPreviewController::class, 'sendProductPDF'])->name('send-product-pdf');

        Route::post('/add-to-cart', [ProductPreviewController::class, 'addToCart'])->name('add-to-cart');
        Route::get('/cart', [ProductPreviewController::class, 'cart'])->name('cart');
    });

    Route::get('histories', [HistoryController::class, 'index'])->name('histories');
    Route::get('download-history/{id}', [HistoryController::class, 'downloadPDF'])->name('download-history');
});
