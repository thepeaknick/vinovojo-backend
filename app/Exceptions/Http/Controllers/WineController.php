<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rate;

use App\Wine;

use App\Winery;

use App\Category;

use App\WineClass;

use Illuminate\Support\Facades\Auth;

class WineController extends Controller {

	public function categoryWines($categoryId, Request $r) {
		$languageId = $r->header('Accept-Language');

		$wines = Wine::list($languageId, 'asc', true)->where('category_id', $categoryId)->get();

		$paginated = $wines->paginate(10);
		return response()->json($paginated, 200);
	}

	public function wineryWines($wineryId, $categoryId, Request $r) {
		$languageId = $r->header('Accept-Language');

		$wines = Wine::list($languageId, 'asc', true)->where('category_id', $categoryId)
								 ->where('winery_id', $wineryId);

		return response()->json($wines->paginate(10), 200);
	}

	public function loadWineComments($wineId) {
		$wine = Wine::where('id', $wineId)->first();
		$wine->comments->load('user');

		if (!$wine) 
			return response()->json(['error' => 'Wine not found'], 404);

		$rates = $wine->comments()->with('user')->where('status', 'approved')->paginate(10);

		return response()->json($rates, 200);
	}

	public function loadWineCommentsForAdmin($wineId) {
		$wine = Wine::where('id', $wineId)->first();

		if (!$wine) 
			return response()->json(['error' => 'Wine not found'], 404);

		$rates = $wine->rates()->with('user')->paginate();

		return response()->json($rates, 200);

	}

	public function initializeFilter(Request $r) {
		$langId = $r->header('Accept-Language');
		$wineries = Winery::dropdown($langId);
		$categories = Category::dropdown($langId);
		$classes = WineClass::dropdown($langId);
		$areas = Area::dropdown($langId);

		$wines = Wine::select('harvest_year', 'alcohol')->get();
		$years = $wines->pluck('harvest_year');
		$alcohol = $wines->pluck('alcohol');

		return response()->json( compact('wineries', 'categories', 'years', 'alcohol', 'classes', 'areas'), 200 );
	}

	public function filter(Request $r, $paginate = true) {
		$lang = $r->header('Accept-Language');

		if ( $r->has('sort') )
			$sort = ($r->sort_name == 1) ? 'asc' : 'desc';
		else
			$sort = 'asc';

		$q = Wine::list($lang, $sort, true);

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

		if ( $r->has('category_id') )
			$q->where('wines.category_id', $r->category_id);

		if ( $r->has('class_id') )
			$q->where('wines.classification_id', $r->class_id);

		if ( $r->has('area_id') )
			$q->where('wines.area_id', $r->area_id);

		$q->orderBy('harvest_year', 'asc');
		
		return ($paginate) ? $q->paginate(10) : $q->get();
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


}
