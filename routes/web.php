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
