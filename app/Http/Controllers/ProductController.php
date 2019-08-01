<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use DB;
use App\Product;
use App\Blist;
use App\Helpers\Common;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['rate', 'addToList']]);
    }
    
    public function show($id)
    {
        $item = Product::findOrFail($id)
            ->load(['quantityprices', 'brand', 'category', 'blists']);
        $rating = Common::avgrating($item);
        $favoriteCount = $item->favoritedBy->count();

        if (Auth::check()) {
            $isMyFav = $item->favoritedBy->contains('id', Auth::user()->id);
            $myRating = 0;
            $r = $item->ratedBy->find(Auth::user()->id);
            if ($r != null) {
                $myRating = $r->rating->score;
            }
        }

        return response()->json(compact(['item', 'rating', 
            'favoriteCount', 'isMyFav', 'myRating']));
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

        $id = $request->input('id');
        $item = Product::findOrFail($id);

        if (Auth::user()->ratedProducts->contains($id)) {
            if ($rating > 0) {
                Auth::user()->ratedProducts()
                    ->updateExistingPivot($id, ['score'=>$rating]);
            } else {
                Auth::user()->ratedProducts()->detach($id);
            }
        } else if ($rating > 0) {
            Auth::user()->ratedProducts()->attach($id, ['score'=>$rating]);
        }

        $item->save();

        $rating = Common::avgrating($item);

        return response()->json([
            'status' => 'success',
            'rating' => $rating,
        ]);
    }

    public function addToList(Request $request)
    {
        $id = $request->input('id');
        $item = Product::findOrFail($id);

        $blistid = $request->input('list');
        $blist = Blist::findOrFail($blistid);

        $this->authorize('update', $blist);

        DB::beginTransaction();
        try {
            $action = 'added';
            if ($blist->products->contains($id)) {
                $blist->products()->detach($id);
                $action = 'removed';
            } else {
                $blist->products()->attach($id, [
                    'position' => $blist->products->count() + 1
                ]);
            }
            $blist->touch();
            $item->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'status' => 'error',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'name' => $blist->name,
            'lists' => $item->blists,
        ]);
    }

    public function favorite(Request $request)
    {
        $id = $request->input('id');
        $item = Product::findOrFail($id);

        $action = 'added';
        if (Auth::user()->favoriteProducts->contains($id)) {
            Auth::user()->favoriteProducts()->detach($id);
            $action = 'removed';
        } else {
            Auth::user()->favoriteProducts()->attach($id);
        }

        $item->save();

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'count' => $item->favoritedBy->count(),
        ]);
    }
}
