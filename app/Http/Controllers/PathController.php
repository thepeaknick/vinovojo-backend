<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\WinePath;

use App\Winery;

use App\PointOfInterest;

use GuzzleHttp\Client;

class PathController extends BaseController
{

    // params:
    // lat
    // lng
    // radius
    // time
    public function inRange(Request $req) {
        $query = PointOfInterest::filterByDistance($req->header('Accept-Language'), $req->lat, $req->lng, true);
        $pois = $query->orderBy('distance', 'asc')->having('distance', '<=', $req->radius)->get();
        $controller = $this;
        $origin = [
            $req->lat,
            $req->lng
        ];

        return $pois->filter(function($poi, $index) use ($controller, $origin, $req) {
            $matrix = $controller->checkDistance( $origin, $poi->only(['lat', 'lng'])->all() );
            if ( !isset($matrix['duration']) )
                return false;

            if ( $matrix['duration']['value'] > ($req->time / 60) )
                return false;

            $poi->time = round($matrix['duration']['value'] / 60, 2);
            return true;
        });
    }

    // params:
    // lat - user lat
    // lng - user lng
    // radius - desired radius
    // winery_time - time per winery
    // total_time - total time
    public function generatePath(Request $req) {
        $wineries = Winery::filterByDistance($req->header('Accept-Language'), $req->lat, $req->lng, true);
        $wineries = $wineries->orderBy('distance', 'asc')->having('distance', '<', $req->radius)->take(10)->get();

        $origin = [
            'lat' => $req->lat,
            'lng' => $req->lng
        ];
//        dd($wineries);
        // return $wineries;

        // total time in seconds
        $totalTime = 0;

        // winery time received in minutes and converted into seconds
        $wineryTime = $req->winery_time * 60;

        // maxTime recieved in minutes and converted into seconds
        $maxTime = $req->total_time * 60;


        $points = collect([]);

        while ( $totalTime < $maxTime && $wineries->isNotEmpty() ) {

            $winery = $wineries->shift();
            $points->push( $winery );
            $destination = $winery->pin->only(['lat', 'lng']);
            $matrix = $this->checkDistance($origin, $destination);
            $origin = $destination;
            $totalTime += $wineryTime + $matrix['duration']['value'];

        }

        return [
            'time' => $totalTime / 60,
            'points' => $points
        ];
    }

    private function checkDistance($origin, $destination) {
        $guzzle = new Client([
            'base_uri' => 'https://maps.googleapis.com'
        ]);

        // $route = 'maps/api/directions/json';
        $route = 'maps/api/distancematrix/json';
        $params = [
            'origins' => implode(',', $origin),
            'destinations' => implode(',', $destination),
            // 'waypoints' => implode('|', $wps),
            'key' => config('services.maps.key')
        ];


        // handluj response
        $response = $guzzle->get($route, [
            'query' => $params
        ]);
//        dd(json_decode($response->getBody(),true)['status']);

        $json = json_decode($response->getBody(), true);

        if ( $response->getStatusCode() != 200 || $json['status']==='REQUEST_DENIED')
            return false;
//            dd($json);

        return $json['rows'][0]['elements'][0];
    }



}
