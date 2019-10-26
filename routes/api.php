<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/customers', 'Api\CustomerController@store');
Route::get('/customers/{document}', 'Api\CustomerController@show');
Route::get('/categories', 'Api\CategoryController@index');
Route::get('/films', 'Api\FilmController@index');
Route::get('/films/{id}', 'Api\FilmController@show');
Route::post('/rents', 'Api\RentController@store');
Route::get('/customers/{id}/rents', 'Api\CustomerController@rents');
