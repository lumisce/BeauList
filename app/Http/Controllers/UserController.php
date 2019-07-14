<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\User;
use App\Helpers\Common;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['profile']]);
    }

    public function show($id)
    {
        if (Auth::check() && Auth::user()->id == $id ) {
            return redirect('profile');
        }
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function wishlist($id)
    {
       
    }

    public function currentProducts($id)
    {
       
    }

    public function ratedProducts($id)
    {
        $user = User::findOrFail($id);
        $ratings = $user->ratedProducts->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });
        return view('users.ratedproducts', compact(['user', 'ratings']));
    }

    public function favoriteProducts($id)
    {
        $user = User::findOrFail($id);
        $ratings = $user->favoriteProducts->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });
        return view('users.favproducts', compact(['user', 'ratings']));
    }

    public function favoriteBrands($id)
    {
        $user = User::findOrFail($id);
        return view('users.favbrands', compact('user'));
    }

    public function savedLists($id)
    {
        $user = User::findOrFail($id);
        return view('users.savedlists', compact('user'));
    }

}