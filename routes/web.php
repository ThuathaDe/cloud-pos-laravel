<?php

use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PosController::class, 'index'])->name('pos.index');
Route::post('/produk', [PosController::class, 'storeProduk'])->name('produk.store');
Route::post('/transaksi', [PosController::class, 'storeTransaksi'])->name('transaksi.store');