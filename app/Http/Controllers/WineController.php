<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Area;

use App\Rate;

use App\Wine;

use App\Winery;

use App\WineClass;

use App\TextField;

use App\Category;

use Illuminate\Support\Facades\Auth;

class WineController extends Controller {

	public function categoryWines($categoryId, Request $r) {
		$languageId = $r->header('Accept-Language');

		$wines = Wine::list($languageId, 'asc', true)->where('category_id', $categoryId)->get();
        foreach ($wines as $wine){
            if($wine instanceof \App\Wine && !empty($wine->area_id))
                $areas= \App\Area::where('id',$wine->area_id)->first();

            $areas= \App\Area::with('parent')->where('areas.id','=',$wine->area_id)
                ->join( (new TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
                    $query->select('transliteration.name as name');
                    $query->on('transliteration.object_id', '=', (new \App\Area)->getTable() . '.id');
                    $query->where('transliteration.object_type', (new \App\Area)->flag);
                    $query->where('transliteration.name', 'name');
                    $query->where('transliteration.language_id', $languageId);
                    return $query;
                })->first();
            if(!empty($areas)){
                $areas->name= $areas->value;
                $areas->parent= $areas->parent->parent;
                $wine->areas=$areas;
            }else {
                $wine->areas=null;
            }
        }
        $wine->rate_count= DB::table('rates')->where('object_id','=',$wine->id)->where('object_type','=','2')->where('status','=','approved')->where('rates.rate','!=','null')->get()->count();

		$paginated = $wines->paginate(10);
		return response()->json($paginated, 200);
	}

	public function wineryWines($wineryId, $categoryId, Request $r) {
		$languageId = $r->header('Accept-Language');
		$wines = Wine::list($languageId, 'asc', true)->where('category_id', $categoryId)
								 ->where('winery_id', $wineryId)->get();


        foreach ($wines as $wine){
            if($wine instanceof \App\Wine && !empty($wine->area_id))
                $areas= \App\Area::where('id',$wine->area_id)->first();

            $areas= Area::with('parent')->where('areas.id','=',$wine->area_id)
                ->join( (new TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
                    $query->select('transliteration.name as name');
                    $query->on('transliteration.object_id', '=', (new Area)->getTable() . '.id');
                    $query->where('transliteration.object_type', (new Area)->flag);
                    $query->where('transliteration.name', 'name');
                    $query->where('transliteration.language_id', $languageId);
                    return $query;
                })->first();
            if(!empty($areas)){
                $areas->name= $areas->value;
                $areas->parent= $areas->parent->parent;
                $wine->areas=$areas;
            }else {
                $wine->areas=null;
            }
            $wine->rate_count= DB::table('rates')->where('object_id','=',$wine->id)->where('object_type','=','2')->where('status','=','approved')->where('rates.rate','!=','null')->get()->count();
        }

		return response()->json($wines->paginate(10), 200);
	}

	public function loadWineComments(Request $r,$wineId) {
        if($wineId==='panel' || $wineId==='all')
            return $this->loadAllWineComments($r);

		$wine = Wine::where('id', $wineId)->first();
		$wine->comments->load('user');

		if (!$wine)
			return response()->json(['error' => 'Wine not found'], 404);

		$rates = $wine->comments()->with('user')->where('status', 'approved')->paginate(10);

		return response()->json($rates, 200);
	}

	public function loadWineCommentsForAdmin(Request $r, $wineId) {
        if($wineId==='panel' || $wineId==='all')
            return $this->loadAllWineCommentsForAdmin($r);

        $rates = Wine::where('id', $wineId)->first();
		if (!$rates)
            return response()->json(['error' => 'Wine not found'], 404);

        $q= Rate::with('user')->join('wines',function ($query) {
            $query->on('wines.id','=','rates.object_id');

        })
        ->join('text_fields as wineTransliteration',function($join) {
            $join->on('wines.id','=','wineTransliteration.object_id');
            $join->where('wineTransliteration.name','=','name');
            $join->where('wineTransliteration.object_type','=',(new Wine)->flag);
            $join->where('wineTransliteration.name','=','name');
        })->join('users',function($join) {
            $join->on('rates.user_id','=','users.id');
        })->where('wines.id',$wineId)->select(['wineTransliteration.value as name', 'rates.*', 'rates.status']);

        $req= app('request');
        if($req->header('SortBy') && !empty($req->header('SortBy')))
        {
            $sort= $req->header('Sorting','asc');
            $q->orderBy($req->header('SortBy'), $sort);
        }else {
            $q->orderBy('rates.updated_at','desc');
            $q->orderBy('rates.status','asc');

        }
        $data= $q->paginate(10)->toArray();

        $data['name']= Wine::where('wines.id',$wineId)->join('text_fields',function($join) {
            $join->on('wines.id','=','text_fields.object_id');
            $join->where('text_fields.object_type',(new Wine)->flag);
            $join->where('text_fields.name','name');
        })->first()->value;
        return response()->json($data);
        // $rates = $wine->rates()->with('user')->paginate();

		return response()->json($data, 200);
    }
    
    public function loadAllWineComments(Request $r, $paginate=true) 
	{
        $user= Auth::user();
        $q= Rate::with('user')->join('wines',function ($query) {
            $query->on('wines.id','=','rates.object_id');

        })->join('text_fields as wineTransliteration',function($join) {
                $join->on('wines.id','=','wineTransliteration.object_id');
                $join->where('wineTransliteration.name','=','name');
                $join->where('wineTransliteration.object_type','=',(new Wine)->flag);
                $join->where('wineTransliteration.name','=','name');
            })->join('users',function($join) {
                $join->on('rates.user_id','=','users.id');
            })->select(['wineTransliteration.value as name', 'rates.*', 'rates.status'])
        ->orderBy('rates.status','asc');
        if($user!==null && ($user->type=='admin' || $user->type=='winery_admin')) {
            return ($paginate)?$q->paginate(10):$q;
        }
        $q->where('rates.status','approved');
        return ($paginate)?$q->paginate(10):$q;
	}

    public function loadAllWineCommentsForAdmin(Request $r)
    {
        $user= Auth::user();
        if($user==null)
            return $this->loadAllWineComments($r);

        $query= "
            SELECT wines.id
            FROM wineries
            JOIN wines
                ON wines.winery_id=wineries.id
            WHERE wineries.id IN (
                SELECT wineries.id
                FROM user_winery
                LEFT JOIN wineries
                ON wineries.id= user_winery.winery_id
                WHERE user_winery.user_id= $user->id
            )
        ";
        $q= Rate::with('user')->join('wines',function ($join) {
                $join->on('wines.id','=','rates.object_id');
            })
            ->join('text_fields as wineTransliteration',function($join) {
                    $join->on('wines.id','=','wineTransliteration.object_id');
                    $join->where('wineTransliteration.name','=','name');
                    $join->where('wineTransliteration.object_type','=',(new Wine)->flag);
                    $join->where('wineTransliteration.name','=','name');
                })
            ->join('users',function($join) {
                    $join->on('rates.user_id','=','users.id');
                })
            ->select(['wineTransliteration.value as name', 'rates.*', 'rates.status']);
        $req= app('request');
        if($req->header('SortBy') && !empty($req->header('SortBy')))
        {
            $sort= $req->header('Sorting','asc');
            $q->orderBy($req->header('SortBy'), $sort);
        }else {
            $q->orderBy('rates.updated_at','desc');
            $q->orderBy('rates.status','asc');
        }
        $wines= DB::select(DB::raw($query));
        $wine_ids=[];
        foreach($wines as $wine)
            $wine_ids[]= $wine->id;

        if($user->type=='winery_admin') 
            $q->whereIn('wines.id',$wine_ids);
        if($user->type=='admin')
            return $q->paginate(10);//->whereIn('object_id',$wine_ids)->paginate(10);
        return $q->where('rates.status','approved')->paginate(10);
    }

	public function initializeFilter(Request $r) {
		$langId = $r->header('Accept-Language');
		$wineries = Winery::dropdown($langId);
		$categories = Category::dropdown($langId);
		$classes = WineClass::dropdown($langId);
		$areas = Area::dropdown($langId);

		$wines = Wine::select('harvest_year', 'alcohol')->get();
		$yearss = ($wines->pluck('harvest_year')->unique()->toArray());
        $years=[];
        foreach($yearss as $year) {
            $years[]=$year;
        }
		$alcoholl = (array)($wines->pluck('alcohol')->unique()->toArray());
		$alcohol=[];
		foreach ($alcoholl as $alc) {
            $alcohol[] = $alc;
        }

		return response()->json( compact('wineries', 'categories', 'years', 'alcohol', 'classes', 'areas'), 200 );
	}

	public function initalizeFilterMobile(Request $r)
    {
        $langId = $r->header('Accept-Language');
        $wineries = Winery::dropdown($langId);
        $categories = Category::dropdown($langId);
        $classes = WineClass::dropdown($langId);

        $wines = Wine::select('harvest_year', 'alcohol')->get();
        $yearss = ($wines->pluck('harvest_year')->unique()->toArray());
        $years=[];
        foreach($yearss as $year){
            $years[]=$year;
        }
        $alcoholl = (array)($wines->pluck('alcohol')->unique()->toArray());
        $alcohol=[];
        foreach ($alcoholl as $alc) {
            $alcohol[] = $alc;
        }

        $areas= Area::with('parent')
            ->join( (new TextField)->getTable() . ' as transliteration', function ($query) use ($langId) {
                $query->select('transliteration.name as name');
                $query->on('transliteration.object_id', '=', (new Area)->getTable() . '.id');
                $query->where('transliteration.object_type', (new Area)->flag);
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

        return response()->json( compact('wineries', 'categories', 'years', 'alcohol', 'classes', 'areas'), 200 );
    }

	public function filter(Request $r, $paginate = true) {
		$lang = $r->header('Accept-Language');

        if($r->has('sort'))
            $sort= ($r->sort==1)?'asc':'desc';
        else $sort= 'asc';

        $q = Wine::list($lang, $sort, true);
        // print_r($q->toSql());die();
		if ( $r->has('min_rate') )
			$q->having( app('db')->raw('avg(rates.rate)'), '>', $r->min_rate);

		if ( $r->has('harvest_year') )
			$q->where('wines.harvest_year', $r->harvest_year);

		if ( $r->has('winery_id') )
			$q->where('wines.winery_id', $r->winery_id);

		if ( $r->has('alcohol') )
			$q->where('wines.alcohol', $r->alcohol);

		if ( $r->has('recommended') )
			$q->where('wines.recommended', $r->recommended);

		if ( $r->has('category_id') ) {
		    $q->where('wines.category_id','=',$r->category_id);
//		    $q->addSelect('wines.category_id as category_id');
//            $q->where('wines.category_id', $r->category_id);
        }

//		if ( $r->has('class_id') )
//			$q->where('wines.classification_id', $r->class_id);
        if($r->has('class_id')) {
            $q->join('classes_wines as classes_w',function($join) use($r) {
                $join->on('wines.id','=','classes_w.wine_id');
                $join->where('classes_w.class_id',$r->class_id);
            });
        }
        $q->with('classes');

        if($r->has('search'))
            $q->where('wines.name','like','%'.$r->search.'%');

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
            $areas= DB::select( DB::raw($query));
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wines.area_id', array_unique($area_ids));
        }

		$q->orderBy('harvest_year', 'asc');

		$data= $q->get();
		foreach($data as $wine) {
            if($wine instanceof \App\Wine && !empty($wine->area_id))
                $areas= Area::where('id',$wine->area_id)->first();

            $areas= Area::with('parent')->where('areas.id','=',$wine->area_id)
                ->join( (new TextField)->getTable() . ' as transliteration', function ($query) use ($lang) {
                    $query->select('transliteration.name as name');
                    $query->on('transliteration.object_id', '=', (new Area)->getTable() . '.id');
                    $query->where('transliteration.object_type', (new Area)->flag);
                    $query->where('transliteration.name', 'name');
                    $query->where('transliteration.language_id', $lang);
                    return $query;
                })->first();
            if(!empty($areas)){
                $areas->name= $areas->value;
                $areas->parent= $areas->parent->parent;
                $wine->areas=$areas;
            }else {
                $wine->areas=null;
            }
        }
		return ($paginate) ? $data->paginate(10) : $data;
	}

	public function filterWithoutPagination(Request $r) {
		return $this->filter($r, false);
	}

	public function searchedForWines(Request $r) {
		$langId = $r->header('Accept-Language');
		$list = Wine::list($langId, true);
		$list->select('wines.id as id', 'wineTransliteration.value as name');
		$list->orderBy('wines.search_count', 'desc');
		$list->take(5);
		$wines = $list->get();
		$wines->makeHidden(['cover_image', 'bottle_image', 'winery']);
		return $wines;
	}

	public function paginateAllCategories(Request $req) {
		$languageId = $req->header('Accept-Language');

		$sorting = $req->header('Sort');
		$sortBy = $req->header('Sort-By');
		if ( is_null($sorting) )
			$sorting = 'asc';
		if ( is_null($sortBy) )
			$sortBy = 'name';

		$query = Category::select( ['wine_categories.id as id', 'transliteration.value as name'] );
		if ($sortBy !== 'wine_count')
    	    $query->orderBy( $sortBy, $sorting );
    	else {
    		$query->addSelect(DB::raw('count(wines.id) as wine_count'));
    		$query->join('wines', 'wines.category_id', '=', 'categories.id');
    		$query->sortBy('wine_count', $sorting);
    	}

        $query->join('text_fields as transliteration', function ($query) use ($languageId) {
            $stat = new Category;
            $query->on('transliteration.object_id', '=', $stat->getTable() . '.id');
            $query->where('transliteration.object_type', '=', $stat->flag);
            $query->where('transliteration.name', 'name');
            $query->where('transliteration.language_id', $languageId);
        });

        $data = $query->paginate(10);

        return $data;
	}

	public function getHighlighted(Request $req) {
		$lang = $req->header('Accept-Language');
		$query = Wine::list($lang, 'asc', true);

		$data = $query->where('wines.highlighted', '1')->get();

		return $data;
	}

	public function userWines(Request $req, $getQuery = false) {
		$wineryIds = Auth::user()->winery()->pluck('wineries.id as id');
		$query =  Wine::list($req->header('Accept-Language'), 'asc', true)
					 ->whereIn('winery_id', $wineryIds->all());

		return ($getQuery) ? $query : $query->paginate(10);
	}

	public function userWinesDropdown(Request $req) {
		$data = $this->userWines($req, true)->get();
		return $data->map(function($win) {
			return [
				'id' => $win->id,
				'name' => $win->name
			];
		});
    }
    
    public function loadWinesForMobile(Request $req)
    {
        $languageId= $req->header('Accept-Language','1');
        $q= Wine::listByWineryDistance($req, $languageId);
        return response()->json($q->paginate(10));
    }

}
