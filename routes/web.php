<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportFlowerController;
use App\Http\Controllers\ImportFlowerController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//Login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::get('/authenticate', [LoginController::class, 'authenticate'])->name('login.authen');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/home/get-bar-chart', [HomeController::class, 'getBarChart'])->name('home.getBarChart');

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

// Import Flower
Route::get('/import-flower', [ImportFlowerController::class, 'index'])->name('importFlower.index');
Route::get('/import-flower/store', [ImportFlowerController::class, 'StoreImportFlower'])->name('importFlower.store');
Route::get('/import-flower/statistic', [ImportFlowerController::class, 'StatisticImportFlower'])->name('importFlower.statistic');


