<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth', 'user.type:super-admin,admin'],
], function() {

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])
        ->name('categories.trash');
    Route::patch('/categories/{category}/restore', [CategoriesController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('/categories/{category}/force', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');

    Route::resources([
        'categories' => CategoriesController::class,
        'products' => ProductsController::class,
    ]);
});