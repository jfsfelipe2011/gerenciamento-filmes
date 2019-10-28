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

Route::post('/customers', 'Api\CustomerController@store')->middleware('auth:api');
Route::get('/customers/{document}', 'Api\CustomerController@show')->middleware('auth:api');
Route::get('/categories', 'Api\CategoryController@index')->middleware('auth:api');
Route::get('/films', 'Api\FilmController@index')->middleware('auth:api');
Route::get('/films/{id}', 'Api\FilmController@show')->middleware('auth:api');
Route::post('/rents', 'Api\RentController@store')->middleware('auth:api');
Route::get('/customers/{id}/rents', 'Api\CustomerController@rents')->middleware('auth:api');
