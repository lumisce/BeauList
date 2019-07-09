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
    return redirect()->route('home');
});

Route::resource('categories', 'CategoryController')->only([
	'index', 'show'
]);

Route::resource('brands', 'BrandController')->only([
	'index', 'show'
]);

Route::post('products/new', 'ProductController@new')->name('products.new');

Route::resource('products', 'ProductController')->only([
	'show'
]);

Route::resource('lists', 'BlistController')->only([
	'index', 'show', 'create', 'store'
]);

Route::post('users/rating', 'UserController@rating')->name('users.rating');

Route::resource('users', 'UserController')->only([
	'show'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'UserController@profile')->name('profile');
