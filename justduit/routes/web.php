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




Route::prefix('shoes')->middleware('auth')->group(function(){
    Route::get('', 'ShoesController@index');
    Route::get('/create', 'ShoesController@create');
    Route::post('', 'ShoesController@store');
    Route::get('/{shoe}/edit', 'ShoesController@edit');
    Route::put('/{shoe}', 'ShoesController@update');
    Route::get('/{shoe}', 'HomeController@show')->withoutMiddleware('auth');
});

Route::get('addToCart/{shoe:id}', 'CartController@show');
Route::post('addToCart/{shoe:id}', 'CartController@store');
Route::get('/cartIndex', 'CartController@index');

Route::get('/cartUpdate/{shoe:id}/edit', 'CartController@edit');
Route::patch('/cartUpdate/{shoe:id}/edit', 'CartController@update');

Route::view('/transaction', '/transactions/history');

Route::get('/', 'HomeController@index');
Route::get('/search', 'HomeController@search');


