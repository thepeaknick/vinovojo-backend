<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use DB;

use App\Area;

use App\Rate;

use App\Winery;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class WineryController extends BaseController
{

	public function loadWineryComments(Request $r, $wineryId) {
        if($wineryId==='panel' || $wineryId==='all')
            return $this->loadAllWineryComments($r);

		$winery = Winery::where('id', $wineryId)->first();

		if ( !$winery )
			return response()->json(['error' => 'Winery not found'], 404);

		$rates = $winery->rates()->with('user')->where('status', 'approved')->paginate(10);

		return response()->json($rates, 200);
	}

	public function loadWineryCommentsForAdmin(Request $r,$wineId) {
        if($wineId==='panel' || $wineId==='all') {
            $admin= $this->loadAllWineryCommentsForAdmin($r, false);
            $all_comments= $this->loadAllWineryComments($r, false)->get();
            $coll= collect();
            if($admin!==NULL) {
                foreach($admin as $admins_comm) 
                    $coll->push($admins_comm);
            }
            foreach($all_comments as $comments) 
                $coll->push($comments);
            return $coll->paginate(10);
        }
        // $rates= $this->loadAllWineryCommentsForAdmin($r, false)->where('wineries.id','=',$wineId)->paginate(10);
        $q= Rate::with('user')->join('wineries',function ($query) {
            $query->on('wineries.id','=','rates.object_id');

        })->join('text_fields as wineryTransliteration',function($join) {
            $join->on('wineries.id','=','wineryTransliteration.object_id');
            $join->where('wineryTransliteration.name','=','name');
            $join->where('wineryTransliteration.object_type','=',(new Winery)->flag);
            $join->where('wineryTransliteration.name','=','name');
        })->join('users',function($join) {
            $join->on('rates.user_id','=','users.id');
        })->where('wineries.id','=',$wineId)->select(['wineryTransliteration.value as name', 'rates.*', 'rates.status'])
            ->orderBy('rates.updated_at','desc')
            ->orderBy('rates.status','asc');
        $data= $q->paginate(10)->toArray();
        $data['name']= Winery::where('wineries.id',$wineId)->join('text_fields',function($join) {
            $join->on('wineries.id','=','text_fields.object_id');
            $join->where('text_fields.object_type',(new Winery)->flag);
            $join->where('text_fields.name','name');
        })->first()->value;
        return response()->json($data);
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
        $areas= Area::with('parent')
            ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($langId) {
                $query->select('transliteration.name as name');
                $query->on('transliteration.object_id', '=', (new Area)->getTable() . '.id');
                $query->where('transliteration.object_type', (new Area)->flag);
                $query->where('transliteration.name', 'name');
                $query->where('transliteration.language_id', $langId);
//                        $query->select('transliteration.name','name');
                return $query;
            });
        $winery_ids= Winery::pluck('id')->toArray();
        $not_empty_areas_query= "
            SELECT
                a.id as a_id,
                p_a.id as p_id,
                pp_a.id as pp_id
            FROM wineries w
            JOIN areas a
            INNER JOIN areas p_a
                ON a.parent_id=p_a.id
            INNER JOIN areas pp_a
                ON p_a.parent_id= pp_a.id
            WHERE a.id= w.area_id
            OR p_a.id= w.area_id
            OR pp_a.id= w.area_id  
        ";
        $not_empty_areas= DB::select(DB::raw($not_empty_areas_query));
        $area_ids=[];
        foreach($not_empty_areas as $area) {
            if($area->a_id!==null)
                $area_ids[]= $area->a_id;
            if($area->p_id!==null)
                $area_ids[]= $area->p_id;
            if($area->pp_id!==null)
                $area_ids[]= $area->pp_id;
        }
        foreach ($areas as $area){
            $area->name= $area->value;
            if($area !==null && $area->parent !==null) {
                $area->parent= $area->parent->parent;
            }
        }
        $areas= $areas->whereIn('areas.id', array_unique($area_ids))->get();
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
            $areas= DB::select(DB::raw($query));
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
            if($r->has('sort'))
                $sort= ($r->sort==1)?'asc':'desc';
            else $sort= 'asc';
            $q = Winery::list($langId, $sort, true);
        }
        $q->with('area');
        /**
         * Mobile phone sort By rate
         */
        if(!empty($r->header('SortBy'))) {
            if($r->header('SortBy')==='rate') 
                $q->orderBy('rates.rate', $r->header('Sorting'));
        }
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
            $areas= DB::select(DB::raw($query));
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

        
        if ( $r->has('min_rate') )
            $q->having( app('db')->raw( 'avg(rates.rate)' ), '>', $r->min_rate);

//         if ( $r->has('sort') ) {
//             $q->getQuery()->orders = null;
//             $sort = ( $r->sort == 1 ) ? 'asc' : 'desc';

// //			$q->orderBy('winery.name','DESC');
//             $q->orderBy('rate', $sort);
//        }
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
        if($r->has('sort')) {
            $sort= ($r->sort==1)?'asc':'desc';
        }else $sort= 'asc';
		$wineries= Winery::list($langId,$sort,true)->get();
		return $wineries;
	}

	public function loadAllWinaries(Request $r)
    {
        $langId= $r->header('Accept-Language');
        $winery=new \App\Winery();
        return $winery->loadAllWineries();
    }

    public function loadAllWineryComments(Request $r, $paginate=true)
    {
        $user= Auth::user();
        
        $q= Rate::with('user')->join('wineries',function ($query) {
            $query->on('wineries.id','=','rates.object_id');

        })->join('text_fields as wineryTransliteration',function($join) {
            $join->on('wineries.id','=','wineryTransliteration.object_id');
            $join->where('wineryTransliteration.name','=','name');
            $join->where('wineryTransliteration.object_type','=',(new Winery)->flag);
            $join->where('wineryTransliteration.name','=','name');
        })->join('users',function($join) {
            $join->on('rates.user_id','=','users.id');
        })
        ->orderBy('rates.status', 'asc')
        ->orderBy('rates.updated_at', 'desc')
        ->select(['wineryTransliteration.value as name', 'rates.*', 'rates.status']);
        if($user!==null && ($user->type!=='admin' || $user->type=='winery_admin'))
            return ($paginate)?$q->paginate(10):$q;
        
        // $q=$q->where('status','approved');
        return ($paginate)?$q->paginate(10):$q;

    }

    public function loadAllWineryCommentsForAdmin(Request $r, $paginate=true) 
    {
        $user= Auth::user();

        if($user==null)
            return $this->loadAllWineryComments($r, $paginate);
        // dd($user->type);
        $all_comments= $this->loadSuperAdminWineryComments($r,false);
        if($user->type=='admin' || $user->type=='winery_admin')
            return $all_comments->paginate(10);

        $wineries= $user->winery()->pluck('wineries.id as id')->toArray();
        $q= Rate::with('user')->where('object_type',(new Winery)->flag)->whereIn('object_id',$wineries)->orderBy('rates.updated_at','desc');
        return ($paginate)?$q->paginate(10):$q;
    }

    public function loadSuperAdminWineryComments(Request $r, $paginate=true)
    {
        $req= app('request');
        $q= Rate::with('user')->join('wineries',function ($query) {
            $query->on('wineries.id','=','rates.object_id');

        })->join('text_fields as wineryTransliteration',function($join) {
            $join->on('wineries.id','=','wineryTransliteration.object_id');
            $join->where('wineryTransliteration.name','=','name');
            $join->where('wineryTransliteration.object_type','=',(new Winery)->flag);
            $join->where('wineryTransliteration.name','=','name');
        })->join('users',function($join) {
            $join->on('rates.user_id','=','users.id');
        })->select(['wineryTransliteration.value as name', 'rates.*', 'rates.status']);
        if($req->header('SortBy') && !empty($req->header('SortBy')))
        {
            $sort= $req->header('Sorting','asc');
            $q->orderBy($req->header('SortBy'), $sort);
        }else {
            $q->orderBy('rates.updated_at','desc');
            $q->orderBy('rates.status','asc');

        }
        // $q= Rate::with('user')->where('object_type',(new Winery)->flag)->orderBy('status','asc');
        return ($paginate)?$q->paginate(10):$q;
    }
    
}
