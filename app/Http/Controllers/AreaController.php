<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Area;

class AreaController extends BaseController
{

	public function loadWithChildren($areaId, Request $req) {
		$area = Area::find($areaId);

		if ( !$area )
			return response()->json(['error' => 'Area not found'], 404);

            $lang = $req->header('Accept-Language');

		$area->transliterate( $lang );

		$area->children = $area->children()->paginate(10);

		$area->children->transliterate($lang);
		return $area;
	}

	public function filterByType(Request $req, $type) {
		$langId = $req->header('Accept-language');
		$query = Area::list($langId, 'asc', true);

		$query->where('type', $type);
		return $query->paginate(10);
	}

	public function areaDropdown(Request $req, $type) {
		$languageId = $req->header('Accept-language');
		$data = Area::select('areas.id as id', 'transliteration.value as name')
					->join('text_fields as transliteration', function($query) use ($languageId) {
						$i = new Area;
						$query->on('transliteration.object_id', '=', 'areas.id');
						$query->where('transliteration.object_type', $i->flag);
						$query->where('language_id', $languageId);
						$query->where('name', 'name');
					})
					->where('type', $type)
					->orderBy('name', 'asc')
					->get();
		return $data;
	}

	public function nestedDropdown(Request $req) {
		Area::$listRelationships = [];
		$languageId = $req->header('Accept-language');
        ( isset($languageId) )?$languageId:$languageId=1;
		$regions = Area::list($languageId, 'asc', true)
						->where('type', 'regija')
						->with('children.children')
						->select('areas.id as id', 'transliteration.value as name', 'type')
						->get();

		return $regions->map(function($r) use ($languageId) {
		    $r->transliterate($languageId);
			$r->children->transliterate($languageId);
			$r->children->transform(function ($c) use ($languageId) {
				$c->children->transliterate($languageId);
				return $c;
			});
			return $r;
		});
	}

}
