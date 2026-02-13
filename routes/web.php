<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Management Routes
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    
    // Category Routes
    Route::post('/categories', [MenuController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [MenuController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [MenuController::class, 'deleteCategory'])->name('categories.delete');
    
    // Product Routes
    Route::post('/products', [MenuController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{product}', [MenuController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [MenuController::class, 'deleteProduct'])->name('products.delete');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/sales/{id}/invoice', [OrderController::class, 'saleInvoice'])->name('sales.invoice');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{id}/pay', [OrderController::class, 'payBill'])->name('orders.pay');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/export', [ReportController::class, 'exportExcel'])->name('reports.sales.export');

    // Profile Routes
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::match(['post', 'delete'], '/notifications/delete-read', [NotificationController::class, 'deleteAllRead'])->name('notifications.deleteRead');
    Route::match(['post', 'delete'], '/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');

    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/menu-access', [UserController::class, 'updateMenuAccess'])->name('users.updateMenuAccess');
});

