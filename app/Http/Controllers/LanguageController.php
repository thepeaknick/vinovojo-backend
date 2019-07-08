<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Language;

class LanguageController extends Controller {

    private function resourceClass($resource) {
        return '\App\\' . ucfirst($resource);
    }

    public function loadForMobile(Request $r, $socialId = '-1') {
    	// return response()->json( json_decode($this->json, 1) );
      $langId = $r->header('Accept-Language');

      $language = Language::find($langId);
      if ( !$language )
        return response()->json(['error' => 'Language not found'], 404);

      $lm = $r->header('Last-Modified');
      if ($lm) {
        $carb = new \Carbon\Carbon($lm);
        if ( $language->updated_at->lte($carb) )
          return response(null, 304);
      }

      $data['fields'] = $language->getMobileFields();
      if ( $socialId != '-1' )
        $data['settings']['favourites'] = \App\Favourite::where('social_id', $socialId)->count();

      $data['updated_time'] = $language->updated_at->toDateTimeString();

      return response()->json($data, 200);
    }

    public function loadForWeb(Request $req) {
      $langId = $req->header('Accept-Language');

      $lang = Language::find($langId);
      $fields = $lang->getWebFields();
      return $fields;
    }

    public function deleteLanguageFromResource($resource, $resoruceId, $languageId) {
    	$resource = $this->resourceClass($resource);

    	$flag = app($resource)->flag;
    }

}
