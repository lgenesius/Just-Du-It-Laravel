<?php

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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/shoes', 'ShoesController@index');
Route::get('/shoes/create', 'ShoesController@create');
Route::post('/shoes', 'ShoesController@store');
Route::get('/search', 'HomeController@search');
