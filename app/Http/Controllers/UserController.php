<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\User;
use App\Helpers\Common;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $lists = $user->blists;
        $isMe = Auth::check() && Auth::user()->id == $id;

        return response()->json(compact('user', 'lists', 'isMe'));
    }

    public function wishlist($id)
    {
       
    }

    public function currentProducts($id)
    {
       
    }

    public function ratedProducts($id)
    {
        $ratings = Auth::user()->ratedProducts->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });
        return view('users.ratedproducts', compact('ratings'));
    }

    public function favoriteProducts($id)
    {
        $user = User::findOrFail($id);
        $items = $user->favoriteProducts()->with('quantityprices', 'brand', 'category', 'blists')->get();
        $isMe = Auth::check() && Auth::user()->id == $id;

        $ratings = Auth::user()->favoriteProducts->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });
        return response()->json(compact('user', 'items', 'isMe', 'ratings'));
    }

    public function favoriteBrands($id)
    {
        $user = User::findOrFail($id);
        $items = $user->favoriteBrands;
        $isMe = Auth::check() && Auth::user()->id == $id;

        return response()->json(compact('user', 'items', 'isMe'));
    }

    public function savedBlists($id)
    {
        $user = User::findOrFail($id);
        $items = $user->savedBlists->load('user');
        $isMe = Auth::check() && Auth::user()->id == $id;

        return response()->json(compact('user', 'items', 'isMe'));
    }

}