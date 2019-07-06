<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
	public function index()
	{
		$items = Category::parents()->get();
		$children = Category::children()->get()->groupBy('parent');
		return view('categories.index', compact('items', 'children'));
	}

	public function show()
	{

	}

}
