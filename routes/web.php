<?php

use App\Http\Controllers\AdminController;
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

Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'barang');
    Route::get('/barang', 'barang');
    Route::get('/pembelian', 'pembelian');
    Route::get('/penjualan', 'penjualan');
    Route::get('/supplier', 'supplier');
    Route::get('/kategoribarang', 'kategoribarang');


    Route::post('/tambahbarang', 'createbarang');
    Route::post('/tambahpembelian', 'createpembelian');
    Route::post('/tambahpenjualan', 'createpenjualan');
    Route::post('/tambahsupplier', 'createsupplier');
    Route::post('/tambahkategori', 'createkategori');

    Route::post('/editbarang', 'updatebarang');
    Route::post('/editpembelian', 'updatepembelian');
    Route::post('/editsupplier', 'updatesupplier');

    Route::post('/hapuspenjualan', 'deletepenjualan');
    Route::post('/hapuspembelian', 'deletepembelian');
});
