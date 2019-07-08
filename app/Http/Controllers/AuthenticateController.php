<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;

class AuthenticateController extends BaseController
{
    
	public function login(Request $r) {
		$token = Auth::attempt( $r->only(['email', 'password']) );

		if ( !$token )
			return response()->json(['error' => 'Invalid credentials'], 401);

		return response()->json( ['token' => $token, 'user' => Auth::user()->full_name, 'user_id' => Auth::user()->id, 'user_data' => Auth::user()], 200 );
	}

}
