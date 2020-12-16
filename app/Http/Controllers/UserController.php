<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Social;

use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

	public function register(Request $req) {
		\Log::info('Register zahtev', $req->all());
		if ($req->social == 1) {
			return (new SocialController)->register($req);
		}
		if ( !$req->has(['full_name', 'email', 'password']) )
			return response()->json(['error' => 'Invalid request'], 400);

		if ( User::where('email', $req->email)->where('social', 0)->count() > 0 )
			return response()->json(['error' => 'Already registered'], 400);

		$u = new User($req->all());
		if ( !$u->save() )
			return response()->json(['error' => 'Database error']);

		if ( $req->has('profile_picture') )
			$u->saveProfile( $req->profile_picture );

		return response()->json([
			'user_data' => $u,
			'token' => app('auth')->fromUser($u)
		], 200);
	}

	public function filterUsers(Request $req, $type,$order='full_name',$search='') {
		$query = User::query();
		if ($type == 'admin')
			$query->where('type', 'admin');

		if ($type == 'user')
			$query->where('type', '=', 'user');

		if ($type == 'trusted')
			$query->where('type', 'trusted');

		if ($type == 'winery_admin')
			$query->where('type', 'winery_admin');

		$sort = $req->header('Sorting');

		
		if($req->has('search')) 
			$query->where('users.full_name','like','%'.$req->search.'%');

		$query->orderBy('full_name', $sort);

		if ( is_null($sort) )
			$sort = 'asc';

//        dd($order);
		$query->orderBy($order, $sort);


		return $query->paginate(10);
	}

	public function filterUsersDropdown(Request $req, $type) {
		return \App\User::where('type', $type)->select(['id', 'full_name'])->get();
	}

//	public function patchPassword( Request $r,$id ) {
//	    $user=\App\User::findOrFail($id);
//	    if($r->has('password')) {
//	        $user->password=app( 'hash' )->make( $r->password );
//	        return ($user->save)?response()->json(['message'=>'Password succesifully changed'], 200 ):response()->json(['message'=>'Not found'], 404 );
//        }
//    }
}
