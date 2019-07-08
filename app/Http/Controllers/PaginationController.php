<?php 

namespace App\Http\Controllers;

use App\PointOfInterest;

use Illuminate\Http\Request;

class PaginationController extends Controller {


    public function paginatePois(Request $r) {
    	$lang = $r->header('Accept-Language');
    	$pois = PointOfInterest::list($lang, true);

    	return $pois->paginate();
    }

}
