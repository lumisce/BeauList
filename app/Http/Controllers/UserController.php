<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['profile', 'rating']]);
    }

    public function show()
    {

    }

    public function profile()
    {
        return view('users.profile');
    }

    public function rating(Request $request)
    {
        $request->validate([
            'rating'=>'integer'
        ]);

        $rating = $request->input('rating');

        $productid = $request->input('product');
        $item = Product::findOrFail($productid);

        if (Auth::user()->products->contains($productid)) {
            if ($rating > 0) {
                Auth::user()->products()->updateExistingPivot($productid, ['score'=>$rating]);
            } else {
                Auth::user()->products()->detach($productid);
            }
        } else if ($rating > 0) {
            Auth::user()->products()->attach($productid, ['score'=>$rating]);
        }

        $rating = $item->users->map(function ($user, $key) {
            return $user->rating->score;
        })->avg();

        return response()->json([
            'status' => 'success',
            'rating' => $rating,
            'raters' => $item->users->count()
        ]);
    }
}