<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Brand;
use App\Helpers\Common;

class BrandController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['only' => ['favorite']]);
	}

	public function index()
	{
		$pagination = Brand::all()->sortBy('name')->paginate(20)->toArray();
        $items = array_values($pagination['data']);
        unset($pagination['data']);

		return response()
			->json(compact('items', 'pagination'));
	}

	public function show($id)
	{
		$item = Brand::findOrFail($id);
		$products = $item->products()
			->with('quantityprices', 'brand', 'category', 'blists')->get()
			->sortByDesc(function ($product, $key) {
				return Common::rankscore($product);
		})->values();
		$ratings = $products->mapWithKeys(function ($product, $key) {
			return [$product->id => Common::avgrating($product)];
		});
		$favoriteCount = $item->favoritedBy->count();

		if (Auth::check()) {
			$isMyFav = $item->favoritedBy->contains('id', Auth::user()->id);
		}

		return response()
			->json(compact('item', 'products', 'ratings', 
				'favoriteCount', 'isMyFav'));
	}

	public function favorite(Request $request)
    {
        $id = $request->input('id');
        $item = Brand::findOrFail($id);

        $action = 'added';
        if (Auth::user()->favoriteBrands->contains($id)) {
            Auth::user()->favoriteBrands()->detach($id);
            $action = 'removed';
        } else {
            Auth::user()->favoriteBrands()->attach($id);
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'count' => $item->favoritedBy->count(),
        ]);
    }
}
