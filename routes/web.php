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

Route::post('brands/favorite', 'BrandController@favorite')->name('brands.favorite');
Route::resource('brands', 'BrandController')->only([
	'index', 'show'
]);

Route::get('products/new', 'ProductController@new')->name('products.new');
Route::post('products/rate', 'ProductController@rate')->name('products.rate');
Route::post('products/addtolist', 'ProductController@addToList')->name('products.addtolist');
Route::post('products/favorite', 'ProductController@favorite')->name('products.favorite');

Route::resource('products', 'ProductController')->only([
	'show'
]);

Route::post('lists/save', 'BlistController@save')->name('lists.save');
Route::resource('lists', 'BlistController')->only([
	'index', 'show', 'create', 'store'
]);

Route::get('/profile', 'UserController@profile')->name('profile');
Route::get('/users/{user}/wishlist', 'UserController@wishlist')->name('users.wishlist');
Route::get('/users/{user}/currentproducts', 'UserController@currentProducts')->name('users.currentproducts');
Route::get('/users/{user}/ratedproducts', 'UserController@ratedProducts')->name('users.ratedproducts');
Route::get('/users/{user}/favproducts', 'UserController@favoriteProducts')->name('users.favproducts');
Route::get('/users/{user}/favbrands', 'UserController@favoriteBrands')->name('users.favbrands');
Route::get('/users/{user}/savedlists', 'UserController@savedLists')->name('users.savedlists');
Route::resource('users', 'UserController')->only([
	'show'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
