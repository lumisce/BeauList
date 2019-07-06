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
    return view('index');
});

Route::resource('categories', 'CategoryController')->only([
	'index', 'show'
]);

Route::resource('brands', 'BrandController')->only([
	'index', 'show'
]);

Route::get('products/new', 'ProductController@new');

Route::resource('products', 'ProductController')->only([
	'show'
]);

Route::resource('lists', 'BlistController')->only([
	'index', 'show'
]);

Route::resource('users', 'UserController')->only([
	'show'
]);