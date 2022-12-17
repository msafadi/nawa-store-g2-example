<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\HomeController;
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
// Route::view('/about-us', 'front.pages.about-us');
// Route::view('/contact', 'front.pages.contact');

Route::get('/pages/{name}', [HomeController::class, 'show'])
    ->name('pages');

Route::get('/dashboard/categories', [CategoriesController::class, 'index'])
    ->name('dashboard.categories.index');