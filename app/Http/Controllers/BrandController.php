<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Helpers\Common;

class BrandController extends Controller
{
	public function index()
	{
		$items = Brand::all();
		return view('brands.index', compact('items'));
	}

	public function show($id)
	{
		$item = Brand::findOrFail($id);
		$products = $item->products->sortByDesc(function ($product, $key) {
			return Common::rankscore($product);
		});
		$ratings = $products->map(function ($product, $key) {
			return Common::avgrating($product);
		});
		return view('brands.show', compact('item', 'products', 'ratings'));
	}
}
