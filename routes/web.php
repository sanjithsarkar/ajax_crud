<?php

use App\Http\Controllers\ProductController;
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
});

Route::resource('products', ProductController::class);
Route::post('/store/product', [ProductController::class, 'storeProduct']);
Route::post('/update/product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/delete/product/{id}', [ProductController::class, 'deleteProduct']);
