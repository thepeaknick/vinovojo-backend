<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\WineryController;

use App\Http\Controllers\WineController;

use App\Rate;

class RateController extends BaseController
{
    
	public function filter(Request $req, $object, $id, $status) {
		$model = "App\\" . ucfirst($object);
		// dd($status==='unapproved');
		// dd(Auth::user());
		$is_not_id= $status==='all' || $status==='approved' || $status==='unapproved' || $status==='hold';
		
		if($model=='App\Winery' && $is_not_id) {
			if($status=='all')
				return (new WineryController)->loadAllWineryComments($req,false)->paginate(10);
			else {
				print_r((new WineryController)->loadAllWineryComments($req,false)->where('status',$status)->toSql());die();
				return (new WineryController)->loadAllWineryComments($req,false)->where('status',$status)->paginate(10);
			}
		}

		if($model=='App\Wine' && $is_not_id) {
			if($status=='all')			
				return (new WineController)->loadAllWineComments($req,false)->paginate(10);
			else return (new WineController)->loadAllWineComments($req,false)->where('status',$status)->paginate(10);
		}

		$instance = $model::find($id);
		// dd($instance);
		if (!$instance)
			return response()->json(['error' => 'Model not found'], 404);

		$rates = Rate::with('user')
					   ->where('status', $status)
					   ->where('object_type', $instance->flag)
					   ->where('object_id', $instance->id)
					   ->paginate(10);
		return $rates;
	}

}
