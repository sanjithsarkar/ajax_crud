<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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
    return view('product.index');
})->name('home');

Route::resource('products', ProductController::class);
Route::post('/store/product', [ProductController::class, 'storeProduct']);
Route::post('/update/product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/delete/product/{id}', [ProductController::class, 'deleteProduct']);

Route::resource('tasks', TaskController::class);
Route::delete('/delete/task/{id}', [TaskController::class, 'deleteTask']);