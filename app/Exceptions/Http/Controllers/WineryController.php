<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Winery;

use Illuminate\Support\Facades\Auth;

class WineryController extends BaseController
{
    
	public function loadWineryComments(Request $r, $wineryId) {
		$winery = Winery::where('id', $wineryId)->first();

		if ( !$winery )
			return response()->json(['error' => 'Winery not found'], 404);

		$rates = $winery->rates()->with('user')->where('status', 'approved')->paginate(10);

		return response()->json($rates, 200);
	}



	public function loadWineryCommentsForAdmin(Request $r, $wineId) {
		if($wineId==='all')
			return $this->loadAllWineryCommentsForAdmin($r);
		$winery = Winery::where('id', $wineId)->first();

		if (!$winery) 
			return response()->json(['error' => 'Wine not found'], 404);

		$rates = $winery->rates()->with('user')->latest('created_at')->paginate(10);

		return response()->json($rates, 200);
	}

	public function loadVideo($wineryId) {
		$w = Winery::find($wineryId);

		if (!$w)
			return response()->json(['error' => 'Winery not found'], 404);

		if ( !$w->hasVideo() )
			return response()->json(['error' => 'Video not uploaded'], 404);

		return response()->download( $w->videoFullPath() );
	}

	public function initializeFilter(Request $r) {
		$areas = \App\Area::dropdown( $r->header('Accept-Language') );
		return response()->json(['areas' => $areas], 200);
	}

	public function filter(Request $r) {
		$langId = $r->header('Accept-Language');

		if ( $r->has(['lat', 'lng', 'max_distance']) ) {
			$q = Winery::filterByDistance($langId, $r->lat, $r->lng, true);
			$q->having('distance', '<=', $r->max_distance);
		}
		else {
			$q = Winery::list($langId, 'asc', true);
		}

		// if ( $r->has('area_id') )
		// 	$q->where('wineries.area_id', $r->area_id);

		if ( $r->has('min_rate') )
			$q->having( app('db')->raw( 'avg(rates.rate)' ), '>', $r->min_rate);

		if ( $r->has('sort') ) {
			$q->getQuery()->orders = null;
			$sort = ( $r->sort == 1 ) ? 'asc' : 'desc';
			$q->orderBy('rate', $sort);
		}
		
		$data = $q->get();

		return $data->paginate(10);
	}

	public function userWinery(Request $req, $getQuery = false) {
		$ids = Auth::user()->winery()->pluck('wineries.id as id');
		$query = Winery::list($req->header('Accept-Language'), 'asc', true)
						->whereIn('wineries.id', $ids->all());

		return ($getQuery) ? $query : $query->paginate(10);
	}

	public function userWineryDropdown(Request $req) {
		$data = $this->userWinery($req, true)->get();
		$data->transform(function($win) {
			return [
				'name' => $win->name,
				'id' => $win->id
			];
		});
		return $data;
	}

	public function searchedForWineries(Request $r) {
		$langId = $r->header('Accept-Language');
		$list = Winery::list($langId, true);
		$list->select('wineries.id as id', 'transliteration.value as name');
		$list->orderBy('search_count', 'desc');
		$list->take(5);
		$wines = $list->get();
		$wines->makeHidden(['cover_image', 'logo_image', 'video', 'rate', 'rate_count']);
		return $wines;
	}

	public function ovoJeSamoZaAcu(Request $r) {
		$langId = $r->header('Accept-Language');
		return Winery::list($langId, true)->get();
	}

}
