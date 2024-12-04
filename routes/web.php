<?php

use App\Http\Controllers\Customer\CustomerController;
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

Route::get('/', function () {
    return redirect(route('admin.login'));    
});

Route::get('/tables', [CustomerController::class, 'tables'])->name('customer.tables');
Route::get('/customer-reserve/{refid}', [CustomerController::class, 'customerReserve'])->name('customer.reserve');
Route::get('/customer-order/{refid}', [CustomerController::class, 'customerOrder'])->name('customer.order');
Route::get('/customer-regis/{qr}', [CustomerController::class, 'customerRegis'])->name('customer.regis');
Route::get('/customer-finish/{refid}', [CustomerController::class, 'customerFinish'])->name('customer.finish');
Route::post('/customer-reserve', [CustomerController::class, 'reserve'])->name('customer.book');
Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
Route::post('/customer-add-order', [CustomerController::class, 'addOrder'])->name('customer.add.order');
Route::get('/reservation/{reservation}/invoice', [\App\Http\Controllers\InvoiceController::class, 'generate3'])->name('customer.invoice3');
Route::get('/{order}/delete', [CustomerController::class, 'destroy'])->name('customer.delet.order');


