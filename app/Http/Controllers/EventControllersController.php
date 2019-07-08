<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Happening;

class EventController extends Controller {

    public function eventsInMonth($year, $month, Request $r) {
    	
    	$languageId = $r->header('Accept-Language');

    	$q = Happening::list($languageId, true);
    	$q->whereYear('start', $year);
    	$q->whereMonth('start', $month);
    	$q->orderBy('start', 'desc');
    	return $q->get();
    }

}
