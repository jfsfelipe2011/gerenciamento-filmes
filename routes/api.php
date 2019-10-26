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

Route::post('/users', 'Api\CustomerController@store');
Route::get('/users/{document}', 'Api\CustomerController@show');
Route::get('/categories', 'Api\CategoryController@index');
Route::get('/films', 'Api\FilmController@index');
Route::get('/films/{id}', 'Api\FilmController@show');
