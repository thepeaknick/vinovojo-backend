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

		$query='';
		if($model=='App\Winery')
			$q= (new WineryController)->loadAllWineryComments($req,false);
		if($model=='App\Wine')
			$q= (new WineController)->loadAllWineComments($req,false);

		if($id!=='all' && $model== 'App\Winery')
			$q->where('wineries.id','=',$id);
		
		if($id!=='all' && $model== 'App\Wine')
			$q->where('wines.id','=',$id);

		if($status!=='all')
			$q->where('rates.status',$status);

		return $q->paginate(10);
	}
	// public function filter(Request $req, $object, $id, $status) {
	// 	// dd($status==='unapproved');
	// 	// dd(Auth::user());
	// 	$is_not_id= $status==='all' || $status==='approved' || $status==='unapproved' || $status==='hold';
	// 	dd($id,$status);
	// 	if($model=='App\Winery' && $is_not_id) {
	// 		if($status=='all')
	// 			return (new WineryController)->loadAllWineryComments($req,false)->paginate(10);
	// 		else return (new WineryController)->loadAllWineryComments($req,false)->where('wineries.id',$id)->where('status',$status)->paginate(10);
	// 	}else if($model=='App\Winery') {
	// 		return (new WineryController)->loadAllWineryComments($req,false)->where('wineries.id',$id)->where('status',$status)->paginate(10);
	// 	}

	// 	if($model=='App\Wine' && $is_not_id) {
	// 		if($status=='all')			
	// 			return (new WineController)->loadAllWineComments($req,false)->paginate(10);
	// 		else return (new WineController)->loadAllWineComments($req,false)->where('wines.id',$id)->where('status',$status)->paginate(10);
	// 	}else if($model=='App\Wine') {
	// 		return (new WineController)->loadAllWineComments($req,false)->paginate(10);
	// 	}

	// 	$instance = $model::find($id);
	// 	// dd($instance);
	// 	if (!$instance)
	// 		return response()->json(['error' => 'Model not found'], 404);

	// 	$rates = Rate::with('user')
	// 				   ->where('status', $status)
	// 				   ->where('object_type', $instance->flag)
	// 				   ->where('object_id', $instance->id)
	// 				   ->paginate(10);
	// 	return $rates;
	// }

}
