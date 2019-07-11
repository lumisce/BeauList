<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Blist;
use App\Helpers\Common;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['rate', 'addToList']]);
    }
    public function show($id)
    {
        $item = Product::find($id);
        $rating = Common::avgrating($item);

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

    public function rate(Request $request)
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

    public function addToList(Request $request)
    {
        $productid = $request->input('product');
        $product = Product::findOrFail($productid);

        $blistid = $request->input('list');
        $blist = Blist::findOrFail($blistid);

        $this->authorize('update', $blist);

        $action = 'added';
        if ($blist->products->contains($productid)) {
            $blist->products()->detach($productid);
            $action = 'removed';
        } else {
            $blist->products()->attach($productid);
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
        ]);
    }
}
