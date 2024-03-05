<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
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
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'productList'])->name('products.list');
    Route::get('/category/{category_id}', [ProductController::class, 'productListByCategory'])->name('products.category');
    // Ruta para la búsqueda de productos (GET y POST)
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/search', [ProductController::class, 'search'])->name('products.search.submit');
    Route::get('/ofertas', [ProductController::class, 'sales'])->name('product.sales');
    Route::post('/generar-factura', [InvoiceController::class, 'generateInvoices'])->name('invoice.generateInvoices');
    Route::get('/mis-pedidos', [InvoiceController::class, 'myInvoices'])->name('invoice.myinvoices');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
});

require __DIR__.'/auth.php';
