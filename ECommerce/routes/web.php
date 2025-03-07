<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
Route::post('/admin/products/store', [AdminController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [AdminController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');

Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');
Route::delete('/admin/products/{product}', [AdminController::class, 'destroy'])->name('admin.products.delete');

Route::middleware(['auth', 'admin'])->group(function () {
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/orders/finalize', [OrderController::class, 'finalizeOrder'])->name('orders.finalize');
Route::get('/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');



Route::get('/success', function () {
    return view('orders.success');
})->name('orders.success');





require __DIR__.'/auth.php';
