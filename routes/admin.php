<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('login');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('{admin}', [UserController::class, 'update'])->name('update');
            Route::get('{admin}/edit', [UserController::class, 'edit'])->name('edit');
            Route::get('{admin}/delete', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('barang')->as('barang.')->group(function () {
            Route::prefix('kelola')->group(function () {
                Route::get('/', [\App\Http\Controllers\BarangController::class, 'index'])->name('index');
                Route::get('create', [\App\Http\Controllers\BarangController::class, 'create'])->name('create');
                Route::get('{product}/edit', [\App\Http\Controllers\BarangController::class, 'edit'])->name('edit');
                Route::get('{product}/delete', [\App\Http\Controllers\BarangController::class, 'destroy'])->name('destroy');
            
                Route::post('/', [\App\Http\Controllers\BarangController::class, 'store'])->name('store');
                Route::put('{product}', [\App\Http\Controllers\BarangController::class, 'update'])->name('update');
                Route::put('{product}/status', [\App\Http\Controllers\BarangController::class, 'updateStatus'])->name('updateStatus');
                Route::get('{product}/status/edit', [\App\Http\Controllers\BarangController::class, 'editStatus'])->name('editStatus');
            });

            Route::prefix('keluar')->group(function () {
                Route::get('/', [\App\Http\Controllers\BarangKeluarController::class, 'index'])->name('keluar.index');
                Route::get('create', [\App\Http\Controllers\BarangKeluarController::class, 'create'])->name('keluar.create');
                Route::get('{product}/edit', [\App\Http\Controllers\BarangKeluarController::class, 'edit'])->name('keluar.edit');
                Route::get('{product}/delete', [\App\Http\Controllers\BarangKeluarController::class, 'destroy'])->name('keluar.destroy');

    
                Route::post('/', [\App\Http\Controllers\BarangKeluarController::class, 'store'])->name('keluar.store');
                Route::put('{product}', [\App\Http\Controllers\BarangKeluarController::class, 'update'])->name('keluar.update');
            });

        
            Route::get('stok', [\App\Http\Controllers\StokBarangController::class, 'index'])->name('stok.index');

            Route::get('list', [\App\Http\Controllers\BarangListController::class, 'index'])->name('list.index');
            Route::get('list/create', [\App\Http\Controllers\BarangListController::class, 'create'])->name('list.create');
            Route::get('list/{product}/edit', [\App\Http\Controllers\BarangListController::class, 'edit'])->name('list.edit');
            Route::post('list', [\App\Http\Controllers\BarangListController::class, 'store'])->name('list.store');
            Route::get('list/{product}/delete', [\App\Http\Controllers\BarangListController::class, 'destroy'])->name('list.destroy');

            Route::put('{product}', [\App\Http\Controllers\BarangListController::class, 'update'])->name('list.update');

            // Route::get('masuk', [\App\Http\Controllers\BarangMasukController::class, 'index'])->name('masuk.index');
            // Route::get('keluar', [\App\Http\Controllers\BarangKeluarController::class, 'index'])->name('keluar.index');
            // Route::get('keluar/{product}/edit', [\App\Http\Controllers\BarangKeluarController::class, 'edit'])->name('keluar.edit');
            // Route::put('keluar/{product}', [\App\Http\Controllers\BarangKeluarController::class, 'update'])->name('keluar.update');
        });

        Route::prefix('menu')->as('menu.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MenuController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\MenuController::class, 'create'])->name('create');
            Route::get('{menu}/edit', [\App\Http\Controllers\MenuController::class, 'edit'])->name('edit');
            Route::get('{menu}/delete', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('destroy');
        
            Route::post('/', [\App\Http\Controllers\MenuController::class, 'store'])->name('store');
            Route::put('{menu}', [\App\Http\Controllers\MenuController::class, 'update'])->name('update');
        });

        Route::prefix('reservation')->as('reservation.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ReservationController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('create');
            Route::get('{reservation}/serve', [\App\Http\Controllers\ReservationController::class, 'serve'])->name('serve');
            Route::get('{reservation}/cancel', [\App\Http\Controllers\ReservationController::class, 'cancel'])->name('cancel');
            Route::get('{reservation}/finish', [\App\Http\Controllers\ReservationController::class, 'finish'])->name('finish');
            Route::get('{reservation}/view', [\App\Http\Controllers\ReservationController::class, 'view'])->name('view');
            Route::get('{reservation}/delete', [\App\Http\Controllers\ReservationController::class, 'destroy'])->name('destroy');

            Route::get('laporan', [\App\Http\Controllers\LaporanTransaksiController::class, 'index'])->name('laporan');

            Route::get('{reservation}/invoice', [\App\Http\Controllers\InvoiceController::class, 'generate'])->name('invoice');
        
            Route::post('/', [\App\Http\Controllers\ReservationController::class, 'store'])->name('store');
            Route::put('{menu}', [\App\Http\Controllers\MenuController::class, 'update'])->name('update');
        });

        Route::prefix('order')->as('order.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ReservationController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('create');
            Route::get('{reservation}/serve', [\App\Http\Controllers\ReservationController::class, 'serve'])->name('serve');
            Route::get('{menu}/edit', [\App\Http\Controllers\MenuController::class, 'edit'])->name('edit');
            Route::get('{order}/delete', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('destroy');
        
            Route::post('/', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
            Route::put('{menu}', [\App\Http\Controllers\MenuController::class, 'update'])->name('update');

            
        });

        Route::prefix('laporan')->as('laporan.')->group(function () {
            Route::get('masuk', [\App\Http\Controllers\LaporanMasukController::class, 'index'])->name('masuk.index');
            Route::get('keluar', [\App\Http\Controllers\LaporanKeluarController::class, 'index'])->name('keluar.index');
            Route::get('transaksi', [\App\Http\Controllers\LaporanTransaksiController::class, 'index'])->name('transaksi.index');

            Route::get('masuk/export', [\App\Http\Controllers\LaporanMasukController::class, 'export'])->name('masuk.export');
            Route::get('keluar/export', [\App\Http\Controllers\LaporanKeluarController::class, 'export'])->name('keluar.export');
            Route::get('transaksi/export', [\App\Http\Controllers\LaporanTransaksiController::class, 'export'])->name('transaksi.export');

        });

        Route::prefix('table')->as('table.')->group(function () {
            Route::get('/', [\App\Http\Controllers\TableController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\TableController::class, 'create'])->name('create');
            Route::get('{refId}/download', [\App\Http\Controllers\TableController::class, 'downloadQRCode'])->name('download');
            Route::get('{refId}/delete', [\App\Http\Controllers\TableController::class, 'deleteTable'])->name('destroy');

            Route::get('order/{refId}', [\App\Http\Controllers\TableController::class, 'index'])->name('order.form');

            Route::post('/', [\App\Http\Controllers\TableController::class, 'addTable'])->name('store');
        });

        Route::prefix('chef')->as('chef.')->group(function () {
            Route::get('/orders', [\App\Http\Controllers\ChefController::class, 'index'])->name('index');
            Route::get('{order}/cancel', [\App\Http\Controllers\ChefController::class, 'cancel'])->name('cancel');
            Route::get('{order}/done', [\App\Http\Controllers\ChefController::class, 'done'])->name('done');
        });

        Route::prefix('cashier')->as('cashier.')->group(function () {
            Route::get('/orders', [\App\Http\Controllers\CashierController::class, 'index'])->name('index');
            Route::get('{reservation}/invoice', [\App\Http\Controllers\InvoiceController::class, 'generate2'])->name('invoice2');
        });

        Route::prefix('supplier')->as('supplier.')->group(function () {
            Route::get('index', [SupplierController::class, 'index'])->name('index');
            Route::get('create', [SupplierController::class, 'create'])->name('create');
            Route::get('{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
            Route::post('store', [SupplierController::class, 'store'])->name('store');
            Route::put('{supplier}/update', [SupplierController::class, 'update'])->name('update');
            Route::delete('{supplier}/destroy', [SupplierController::class, 'destroy'])->name('destroy');
        });

    });
});
