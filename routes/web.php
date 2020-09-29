<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportFlowerController;

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

Route::get('/home', function () {
    return view('welcome');
});
// Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');

//Flower
Route::get('/flower', [FlowerController::class, 'index'])->name('flower.index');
Route::get('/flower/store', [FlowerController::class, 'StoreFlower'])->name('flower.store');

//Customer
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/store', [CustomerController::class, 'StoreCustomer'])->name('customer.store');

// Export Flower

Route::get('/export-flower', [ExportFlowerController::class, 'index'])->name('exportFlower.index');
Route::get('/export-flower/store', [ExportFlowerController::class, 'StoreExportFlower'])->name('exportFlower.store');
Route::get('/export-flower/statistic', [ExportFlowerController::class, 'StatisticExportFlower'])->name('exportFlower.statistic');


