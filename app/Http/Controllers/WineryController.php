<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Winery;

use Illuminate\Support\Facades\Auth;

class WineryController extends BaseController
{

	public function loadWineryComments($wineryId) {
		$winery = Winery::where('id', $wineryId)->first();

		if ( !$winery )
			return response()->json(['error' => 'Winery not found'], 404);

		$rates = $winery->rates()->with('user')->where('status', 'approved')->paginate(10);

		return response()->json($rates, 200);
	}



	public function loadWineryCommentsForAdmin($wineId) {
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

    public function initializeFilterMobile(Request $r) {
	    if(!$r->header('Accept-Language'))
	        return response()->json(['message'=>'not found(Accept-Language)'],404);
	    $langId= $r->header('Accept-Language');
        $areas= \App\Area::with('parent')
            ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($langId) {
                $query->select('transliteration.name as name');
                $query->on('transliteration.object_id', '=', (new \App\Area)->getTable() . '.id');
                $query->where('transliteration.object_type', (new \App\Area)->flag);
                $query->where('transliteration.name', 'name');
                $query->where('transliteration.language_id', $langId);
//                        $query->select('transliteration.name','name');
                return $query;
            })->get();
        foreach ($areas as $area){
            $area->name= $area->value;
            if($area !==null && $area->parent !==null) {
                $area->parent= $area->parent->parent;
            }
        }
        return response()->json(['areas' => $areas], 200);
    }

    public function filterUserWineries(Request $r)
    {
        $ids = Auth::user()->winery()->pluck('wineries.id as id');
        if(!empty($ids) && count($ids)>0) {
            $wineries= $this->FilterWineries($r)->whereIn('wineries.id', $ids->all());
            return response()->json($wineries->paginate(12));
        }else{
            return $this->FilterWineries($r)->paginate(12);
        }

    }

	public function filter(Request $r) {
        $q= $this->FilterWineries($r);

		$data = $q->get();


		return $data->paginate(10);
	}

	public function FilterWineries(Request $r) {
        $langId = $r->header('Accept-Language');

        \Log::info('Distance',['REQUEST'=>$r->all()]);
        if ( $r->has(['lat', 'lng', 'max_distance']) ) {
            $q = Winery::filterByDistance($langId, $r->lat, $r->lng, true);
            $q->having('distance', '<=', $r->max_distance);
        }
        else {
            $q = Winery::list($langId, 'asc', true);

        }

        if ( $r->has('area_id') )
        {
            \Log::info('Filtriranje vinarije po area_id',['area_id',$r->area_id]);
            $area_ids=[];
            $query="
                SELECT
                    a.id as a_id,
                    p_a.id as p_id,
                    pp_a.id as pp_id
                FROM areas a
                INNER JOIN areas p_a
                    ON a.parent_id=p_a.id
                INNER JOIN areas pp_a
                    ON p_a.parent_id= pp_a.id
                WHERE a.id= $r->area_id
                OR p_a.id= $r->area_id
                OR pp_a.id= $r->area_id
            ";
            $areas=\DB::select(\DB::raw($query));
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wineries.area_id', array_unique($area_ids));
        }
//        print_r($q->toSql());die();

        if($r->has('search'))
            $q->where('wineries.name','like','%'.$r->search.'%');


//        dd(array_unique($area_ids));





        if ( $r->has('min_rate') )
            $q->having( app('db')->raw( 'avg(rates.rate)' ), '>', $r->min_rate);

        if ( $r->has('sort') ) {
            $q->getQuery()->orders = null;
            $sort = ( $r->sort == 1 ) ? 'asc' : 'desc';

//			$q->orderBy('winery.name','DESC');
            $q->orderBy('rate', $sort);
        }

        return $q;
    }

    public function filterWithoutPagination(Request $r)
    {
        $langId = $r->header('Accept-Language');

        \Log::info('Distance',['REQUEST'=>$r->all()]);
        if ( $r->has(['lat', 'lng', 'max_distance']) ) {
            $q = Winery::filterByDistance($langId, $r->lat, $r->lng, true);
            $q->having('distance', '<=', $r->max_distance);
        }
        else {
            $q = Winery::list($langId, 'asc', true);
        }
        $q->with('area');
        if ( $r->has('area_id') )
        {
            $area_ids=[];
            $query="
                SELECT
                    a.id as a_id,
                    p_a.id as p_id,
                    pp_a.id as pp_id
                FROM areas a
                INNER JOIN areas p_a
                    ON a.parent_id=p_a.id
                INNER JOIN areas pp_a
                    ON p_a.parent_id= pp_a.id
                WHERE a.id= $r->area_id
                OR p_a.id= $r->area_id
                OR pp_a.id= $r->area_id
            ";
            $areas=\DB::select(\DB::raw($query));
//            dd($areas);
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wineries.area_id', array_unique($area_ids));
//            print_r($q->toSql());die();
        }
        if ( $r->has('min_rate') )
            $q->having( app('db')->raw( 'avg(rates.rate)' ), '>', $r->min_rate);

        if ( $r->has('sort') ) {
            $q->getQuery()->orders = null;
            $sort = ( $r->sort == 1 ) ? 'asc' : 'desc';

//			$q->orderBy('winery.name','DESC');
            $q->orderBy('rate', $sort);
        }
        return response()->json($q->get());
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
		$wineries= Winery::list($langId,'asc',true)->get();
		return $wineries;
//		return Winery::list($langId,'asc',true)->get();
	}

	public function loadAllWinaries(Request $r)
    {
        $langId= $r->header('Accept-Language');
        $winery=new \App\Winery();
        return $winery->loadAllWineries();
    }

}
