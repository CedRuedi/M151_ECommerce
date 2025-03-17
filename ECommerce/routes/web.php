<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
Route::post('/orders/finalize', [OrderController::class, 'finalizeOrder'])->name('orders.finalize');
Route::get('/success', function () {
    return view('orders.success');
})->name('orders.success');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');

    Route::post('/admin/products/store', [AdminController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroy'])->name('admin.products.delete');

    Route::get('/admin/logs', [ActivityLogController::class, 'index'])->name('admin.logs');
});

require __DIR__.'/auth.php';
