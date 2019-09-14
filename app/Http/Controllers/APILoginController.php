<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APILoginController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
    	$credentials = request(['email', 'password']);

    	if (!$token = auth('api')->attempt($credentials)) {
    		return response()->json(['error' => 'Unauthorized'], 401);
    	}

    	return response()->json([
    		'token' => $token,
    		'type' => 'bearer',
    		'expires_in' => auth('api')->factory()->getTTL() * 60,
    		'user' => auth('api')->user()
    	]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


}
