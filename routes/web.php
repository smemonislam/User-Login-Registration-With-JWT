<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\userController;
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

Route::view('/', 'pages.customer')->middleware('token');
Route::view('/register', 'pages.registration-page');
Route::view('/login', 'pages.login-page');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('token');
;
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store')->middleware('token');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('token');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update')->middleware('token');
Route::delete('/customers/{customer}', [CustomerController::class, 'destory'])->name('customers.destory')->middleware('token');


Route::post('/register', [userController::class, 'userRegister'])->name('register');
Route::post('/login', [userController::class, 'userLogin'])->name('login');
