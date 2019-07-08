<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Rate;

class RateController extends BaseController
{
    
	public function filter(Request $req, $object, $id, $status) {
		$model = "App\\" . ucfirst($object);
		$instance = $model::find($id);

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
