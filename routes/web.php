<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Cities\CitiesController;
use App\Http\Controllers\Map\MapController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\Weather\WeatherController;

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








// Cities/Countries
Route::get('/cities', [CitiesController::class, 'index'])->name('cities.index');
Route::get('/cities/create', [CitiesController::class, 'create'])->name('cities.create');
Route::post('/cities', [CitiesController::class, 'store'])->name('cities.store');
Route::get('/cities/{id}/edit', [CitiesController::class, 'edit'])->name('cities.edit');
Route::post('/cities/{id}/update', [CitiesController::class, 'update'])->name('cities.update');
Route::post('/cities/{id}/delete', [CitiesController::class, 'destroy'])->name('cities.destroy');
Route::get('/cities/{id}', [CitiesController::class, 'show'])->name('cities.show');









// Maps
Route::resource('/map', MapController::class);
Route::post('/map/save', [MapController::class, 'StreetSave'])->name('map.save');
Route::get('/find-location', [MapController::class, 'findLocation']);








// Currency
Route::resource('/currency', CurrencyController::class);
Route::get('/currency-quotes', [CurrencyController::class, 'getTopCurrencyQuotes'])->name('currency-quotes.index');
Route::get('/fetch-currency-data', [CurrencyController::class, 'fetchCurrencyData'])->name('fetch-currency-data.index');





// Weather
Route::resource('/weather', WeatherController::class);




// Language
Route::get('/{locale?}', function ($locale = null) {
    if ($locale && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        session(['locale' => $locale]);
    } elseif (session()->has('locale')) {
        app()->setLocale(session('locale'));
    }

    return view('welcome');
})->where('locale', '[a-zA-Z]{2}');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session(['locale' => $locale]);
    return redirect()->back();
})->name('language.switch');


