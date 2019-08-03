<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use DB;
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
        $v = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Auth::user()->blists->contains($attribute, $value)) {
                        $fail($value.' already exists.');
                    }
                },
            ],
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $item = new Blist([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            Auth::user()->blists()->save($item);

            foreach ($request->input('products') as $product) {
                $item->products()->attach($product['id'], [
                    'note' => isset($product['note']) ? $product['note'] : '', 
                    'position' => isset($product['position']) ? $product['position'] : 0
                ]);
            }
            $item->save();
            $item->products()->searchable();
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
            'id' => $item->id,
        ]);
    }

    public function show($id)
    {
        $item = Blist::findOrFail($id)->load('user');

        $products = $item->products()
            ->with('quantityprices', 'brand', 'category', 'blists')
            ->orderBy('pivot_position')->get();

        $ratings = $products->mapWithKeys(function ($product, $key) {
            return [$product->id => Common::avgrating($product)];
        });

        $saveCount = $item->savedBy->count();
        if (Auth::check()) {
            $isSaved = $item->savedBy->contains('id', Auth::user()->id);
            $isMine = $item->user->id == Auth::user()->id;
        }
        return response()->json(compact('item', 'products', 'ratings', 
            'saveCount', 'isSaved', 'isMine'));
    }

    public function update(Request $request, $id)
    {   
        $item = Blist::findOrFail($id);

        $this->authorize('update', $item);
        
        $v = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    if (Auth::user()->blists->except($id)->contains($attribute, $value)) {
                        $fail($value.' already exists.');
                    }
                },
            ],
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ]);
        }

        $item->name = $request->input('name', $item->name);
        $item->description = $request->input('description', $item->description);
        $item->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $item = Blist::findOrFail($id);
        $this->authorize('delete', $item);

        $item->delete();

        return response()->json([
            'status' => 'success',
            'action' => 'delete'
        ]);
    }

    public function syncProducts(Request $request, $id)
    {
        $item = Blist::findOrFail($id);
        $this->authorize('update', $item);

        $products = $request->input('products');

        $modifiedProducts = [];
        foreach ($products as $product) {
            $modifiedProducts[$product['id']] = [
                'note' => isset($product['note']) ? $product['note'] : '', 
                'position' => isset($product['position']) ? $product['position'] : 0
            ];
        }

        DB::beginTransaction();
        try {
            $item->products()->sync($modifiedProducts);
            $item->touch();
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
        ]);
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

        $item->save();

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'count' => $item->savedBy->count(),
        ]);
    }
}
