<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['profile']]);
    }

    public function show()
    {

    }

    public function profile()
    {
        return view('users.profile');
    }
}
