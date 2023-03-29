<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
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
                Route::get('export', [\App\Http\Controllers\BarangController::class, 'export'])->name('export');
                Route::post('/', [\App\Http\Controllers\BarangController::class, 'store'])->name('store');
                Route::put('{product}', [\App\Http\Controllers\BarangController::class, 'update'])->name('update');
            });

            Route::prefix('return')->as('return.')->group(function () {
                Route::get('/', [\App\Http\Controllers\ReturnBarangController::class, 'index'])->name('index');
                Route::get('/{product}', [\App\Http\Controllers\ReturnBarangController::class, 'return'])->name('update');
            });

            Route::get('masuk', [\App\Http\Controllers\BarangMasukController::class, 'index'])->name('masuk.index');
            Route::get('keluar', [\App\Http\Controllers\BarangKeluarController::class, 'index'])->name('keluar.index');

            Route::get('laporan', [\App\Http\Controllers\LaporanBarangController::class, 'index'])->name('laporan.index');
        });
    });
});
