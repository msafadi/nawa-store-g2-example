<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/pages/{name}', [HomeController::class, 'show'])
    ->name('pages');

Route::get('/products/category/{category_slug}', [ProductsController::class, 'index'])
    ->name('products.category');
Route::get('/products', [ProductsController::class, 'index'])
    ->name('products.index');
Route::get('/products/{product_slug}', [ProductsController::class, 'show'])
    ->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store']);

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/payments/{order}', [PaymentsController::class, 'create'])->name('payments');

Route::get('/payments/{order}/return', [PaymentsController::class, 'store'])
    ->name('payments.return');
Route::get('/payments/{order}/cancel', [PaymentsController::class, 'cancel'])
    ->name('payments.cancel');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        //->middleware('password.confirm')
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
