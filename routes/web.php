<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
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

Route::get('/', [Controller::class, 'index'])->name('form');

Route::post('/addcustomer', [AdminController::class, 'store'])->name('addCustomer');

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/customer/edit/{customer}', [AdminController::class, 'edit'])->middleware(['auth'])->name('editcustomer');
Route::post('/customer/update/{customer}', [AdminController::class, 'update'])->middleware(['auth'])->name('updatecustomer');
Route::get('/customer/delete/{customer}', [\App\Http\Controllers\Api\CustomersController::class, 'delete'])->middleware(['auth'])->name('delcustomer');
Route::get('/customer/restore/{customer}', [AdminController::class, 'restore'])->middleware(['auth'])->name('restorecustomer');

require __DIR__.'/auth.php';
