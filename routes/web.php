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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/cart', [
	'uses' =>'ProductController@showCart',
	'as' => 'shopping-cart'
	]);
Route::post('/product/{id}', 'ProductController@addToCart');
Route::get('/product', 'ProductController@showAllProduct');
Route::get('/clearCart', 'ProductController@clearCart');
Route::get('/removeItem/{id}', ['uses'=>'ProductController@removeItem']);
Route::get('/removeAllItem', 'ProductController@removeAllItem');
Route::get('/checkout', [
	'uses' => 'ProductController@getCheckout',
	'as' => 'checkout'
	]);

Route::post('/checkout', [
	'uses' => 'ProductController@postCheckout',
	'as' => 'checkout'
	]);




