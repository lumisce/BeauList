<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
	public function index()
	{
		$items = Brand::all();
		return view('brands.index', compact('items'));
	}

	public function show()
	{
		
	}
}
