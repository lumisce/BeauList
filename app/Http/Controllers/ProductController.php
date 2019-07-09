<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $item = Product::find($id);
        $rating = $item->users->map(function ($user, $key) {
        	return $user->rating->score;
        })->avg();

        $myscore = 0;
        if (Auth::check()) {
        	if ($item->users->contains(Auth::user()->id)) {
        		$myscore = $item->users()->find(Auth::user()->id)->rating->score;
        	}
        }

        return view('products.show', compact(['item', 'rating', 'myscore']));
    }

    public function new()
    {

    }
}
