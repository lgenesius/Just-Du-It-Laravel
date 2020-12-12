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

Route::prefix('cartUpdate')->middleware('auth')->group(function(){
    Route::get('/{shoe:id}/edit', 'CartController@edit');
    Route::patch('/{shoe:id}/edit', 'CartController@update');
    Route::delete('/{shoe:id}/delete', 'CartController@destroy');
});


Route::get('transaction','TransactionController@index');
Route::get('transaction/checkout','TransactionController@checkout');

Route::get('/', 'HomeController@index');
Route::get('/search', 'HomeController@search');


