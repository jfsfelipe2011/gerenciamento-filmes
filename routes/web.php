<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('actors', 'ActorController')->middleware('auth');
Route::resource('directors', 'DirectorController')->middleware('auth');
Route::resource('categories', 'CategoryController')->middleware('auth');
Route::resource('films', 'FilmController')->middleware('auth');
Route::resource('stocks', 'StockController')->middleware('auth');
Route::resource('rents', 'RentController')->middleware('auth');

// Custom routes
Route::get('stocks/{id}/add', 'StockController@add')->name('stocks.add')->middleware('auth');
Route::put('stocks/{id}/update-quantity', 'StockController@updateQuantity')
    ->name('stocks.update.quantity')->middleware('auth');
Route::get('customers', 'CustomerController@index')->name('customers.index')->middleware('auth');
Route::put('rents/{id}/cancel', 'RentController@cancel')->name('rents.cancel')->middleware('auth');
Route::put('rents/{id}/finish', 'RentController@finish')->name('rents.finish')->middleware('auth');
Route::get('customer/{id}/rents', 'CustomerController@showRents')->name('customers.show.rents')->middleware('auth');
