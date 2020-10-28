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

Auth::routes();

Route::get('/shoes', 'ShoesController@index');
Route::get('/shoes/create', 'ShoesController@create');
Route::post('/shoes', 'ShoesController@store');
Route::get('/shoes/{shoe}/edit', 'ShoesController@edit');
Route::put('/shoes/{shoe}', 'ShoesController@update');

Route::get('addToCart/{shoe:id}', 'CartController@show');
Route::post('addToCart/{shoe:id}', 'CartController@store');
Route::view('/cartIndex', '/carts/cartIndex');
Route::get('/updateCart/{CartDetail:id}', 'CartController@update');

Route::view('/transaction', '/transactions/history');


Route::get('/', 'HomeController@index');
Route::get('/search', 'HomeController@search');
Route::get('/shoes/{shoe}', 'HomeController@show');

