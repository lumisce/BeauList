<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Blist;

class BlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index()
    {
        return view('lists.index');
    }

    public function create()
    {
        return view('lists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $item = new Blist([
            'name' => $request->get('name'),
        ]);
        Auth::user()->blists()->save($item);
        return redirect('profile');
    }

    public function show()
    {
        return view('lists.show');
    }

    public function update()
    {

    }
}
