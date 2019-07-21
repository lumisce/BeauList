<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Blist;
use App\Helpers\Common;

class BlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index()
    {
        return view('lists.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $item = new Blist([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        Auth::user()->blists()->save($item);

        return response()->json([
            'status' => 'success',
            'id' => $item->id,
       ]);
    }

    public function show($id)
    {
        $item = Blist::findOrFail($id)->load('user');
        $products = $item->products()->with('quantityprices', 'blists')->get()
            ->sortByDesc(function ($product, $key) {
                return Common::rankscore($product);
        });
        $ratings = $products->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });
        $saveCount = $item->savedBy->count();
        if (Auth::check()) {
            $isSaved = $item->savedBy->contains('id', Auth::user()->id);
            $isMine = $item->user->id == Auth::user()->id;
        }
        return response()->json(compact('item', 'products', 'ratings', 'saveCount', 'isSaved', 'isMine'));
    }

    public function update()
    {

    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $item = Blist::findOrFail($id);

        if ($item->user->id == Auth::user()->id) {
            // can't save own list
        }

        $action = 'added';
        if (Auth::user()->savedBlists->contains($id)) {
            Auth::user()->savedBlists()->detach($id);
            $action = 'removed';
        } else {
            Auth::user()->savedBlists()->attach($id);
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'count' => $item->savedBy->count(),
        ]);
    }
}
