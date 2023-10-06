<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Cities\CitiesController;
use App\Http\Controllers\Reader\ReaderController;

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
// login/register
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

//Route::resource('/cities', CitiesController::class);
//Route::post('/cities/{id}', [CitiesController::class, 'postEdit'])->name('update');


Route::get('/cities', [CitiesController::class, 'index'])->name('cities.index');

Route::get('/cities/create', [CitiesController::class, 'create'])->name('cities.create');

Route::post('/cities', [CitiesController::class, 'store'])->name('cities.store');

Route::get('/cities/{id}', [CitiesController::class, 'show'])->name('cities.show');

Route::get('/cities/{id}/edit', [CitiesController::class, 'edit'])->name('cities.edit');

Route::post('/cities/{id}/update', [CitiesController::class, 'update'])->name('cities.update');

Route::post('/cities/{id}/delete', [CitiesController::class, 'destroy'])->name('cities.destroy');



Route::resource('/reader', ReaderController::class);