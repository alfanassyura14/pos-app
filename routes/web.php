<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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
});

