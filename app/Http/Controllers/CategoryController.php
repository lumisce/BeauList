<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Helpers\Common;

class CategoryController extends Controller
{
	public function index()
	{
		$items = Category::parents()->get();
		$children = Category::children()->get()->groupBy('parent');
		return response()
			->json(compact('items', 'children'));
	}

	public function show($id)
	{
		$item = Category::findOrFail($id);
		$products = $item->products()->with('quantityprices', 'brand', 'category', 'blists')->get()
			->sortByDesc(function ($product, $key) {
				return Common::rankscore($product);
		});
		$ratings = $products->mapWithKeys(function ($product, $key) {
			return [$product->id => Common::avgrating($product)];
		});
		return response()
			->json(compact('item', 'products', 'ratings'));
	}

}
