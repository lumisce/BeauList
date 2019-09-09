<?php

use Illuminate\Http\Request;
use App\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return ['user' => $request->user()->load('blists')];
});

Route::post('register', 'Auth\RegisterController@apiRegister');
Route::post('login', 'Auth\LoginController@apiLogin');

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
Route::post('lists/{list}/products', 'BlistController@syncProducts')->name('lists.syncproducts');
Route::resource('lists', 'BlistController')->except('create', 'edit');

Route::get('profile', 'UserController@profile')->name('profile');
Route::get('users/{user}/wishlist', 'UserController@wishlist')->name('users.wishlist');
Route::get('users/{user}/currentproducts', 'UserController@currentProducts')->name('users.currentproducts');
Route::get('users/{user}/ratedproducts', 'UserController@ratedProducts')->name('users.ratedproducts');
Route::get('users/{user}/favproducts', 'UserController@favoriteProducts')->name('users.favproducts');
Route::get('users/{user}/favbrands', 'UserController@favoriteBrands')->name('users.favbrands');
Route::get('users/{user}/savedlists', 'UserController@savedBlists')->name('users.savedlists');
Route::resource('users', 'UserController')->only([
	'show'
]);
