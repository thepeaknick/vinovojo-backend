<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use DB;

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

    public function calculateRoute(Request $r)
    {
      /*
      | Override app real request
      */
      $req= app('request');
      $langId= $r->header('Accept-Language', 1);
      $limit= ($r->has('limit_points'))?$r->limit_points:100;
      $max_dist= ($r->has('radius'))?$r->radius:50000;
      $r='';
      if(!$req->has('lng') || !$req->has('lat')) {
        return response()->json(['message'=> 'incomplete data'], 422);
      }
      $start= [
        'lng'=> $req->lng,
        'lat'=> $req->lat
      ];

      /*
      |----------------------------------------
      | Find sort wines into wineries
      |----------------------------------------
      */


      $q= Winery::list($langId, 'asc', true);
      $q->join('pins', function($join) {
        $join->on('pins.object_id', 'wineries.id');
        $join->where('pins.object_type', (new Winery)->flag);
      });
      $q->addSelect('wineries.recommended as winery_recommended');
      $q->addSelect('pins.lat as lat');
      $q->addSelect('pins.lng as lng');
      if($req->has('class_id') && !empty($req->class_id))
      {
        $q->leftJoin('wines', function($join) {
          $join->on('wines.winery_id','wineries.id');
        });
        $q->join('classes_wines', function($join) {
            $join->on('wines.id','=','classes_wines.wine_id');
        });
        if(is_array($req->class_id)) {
            $classes= [];
            foreach($req->class_id as $class_id) {
                $classes[]= $class_id;
            }
            $q->whereIn('classes_wines.class_id', $classes);
        }else {
            $q->where('classes_wines.class_id', $req->class_id);
        }
        $q->addSelect('wines.recommended as w_rec');
      }

      $distances= [];
      $wineries= $q->get();
      $point_num=0;
      foreach($wineries as $winery) {
        $point= [
          'point'=> $point_num++,
          'id'=> $winery->id,
          'lng'=> $winery->lng,
          'lat'=> $winery->lat
        ];
        $distance= $this->CalculateDistance($point, $start);
        if($distance<$max_dist) {
          // $point['distance']=$distance;
          $distances[]= $point;
        }
      }
      $points=[];
      /*
      | Find the first nearest node
      */
      usort($distances, function($d1, $d2)use($start) {
        return $this->CalculateDistance($start, $d1)-$this->CalculateDistance($start, $d2);
      });
      $current_node= array_shift($distances);
      $points[] = $current_node['id'];
      /*
      |-------------------------------------------------------------
      | Do it untill point length is smaller than requested number
      | of points
      */
      $current_nodes= [];
      $time=0;
      for($x=0; $x<count($distances) && count($points)<$limit; $x++) {
          $current_node= $distances[$x];
          array_push($current_nodes, $current_node['id']);
          usort($distances, function($d1,$d2)use($current_node) {
            return $this->CalculateDistance($current_node, $d1)- $this->CalculateDistance($current_node, $d2);
          });
          $points[]= $new_point= array_shift($distances)['id'];
          /*
          |---------------------------------------------------------
          | Racunanje vremena stoji dok ne dobijemo kljuc od gmaps
          */
          // $curr= [
          //   'lng'=> $current_node['lng'],
          //   'lat'=> $current_node['lat']
          // ];
          // $new= [
          //   'lng'=> $new_point['lng'],
          //   'lat'=> $new_point['lat']
          // ];
          // try{
          //   $time+= $this->checkDistance($curr, $new);
          // }catch(\Exception $e) {
          // }
        }

        $order_string= implode(',',$points);
      if(!empty($points)) {
          $q->whereIn('wineries.id', $points);
          $q->orderByRaw(DB::raw("FIELD(wineries.id, $order_string)"));
      }
      $q->limit($limit);
      return response()->json(['time'=>$time, 'points'=>$q->get()]);
      // $coords= $q->get()->toArray();
      // $coord_arr= array_map(function($coord) {
      //   return ['lat'=> $coord['lat'],'lng'=> $coord['lng'], 'id'=>$coord['id']];
      // },$coords);
      // $reference= $coord_arr[1];
      // $distances= [];
      // foreach($coord_arr as $index=>$val) {
      //   if($index!==1) {
      //     $distances[]= ['id'=> $val['id'], 'distance'=> $this->CalculateDistance($reference,$coord_arr[$index])];
      //   }
      // }
      // return response()->json(['distances'=>$distances,'coords'=>$coord_arr, 'current_nodes'=>$current_nodes]);

    }

    protected function CalculateDistance(array $point1, array $point2)
    {

        $longitude= $point1['lng'];
        $latitude= $point1['lat'];

        //  Get longitude and latitude in radians
        $lng= $longitude/(180/\pi());
        $lat= $latitude/(180/\pi());

        $lng2= $point2['lng'];
        $lat2= $point2['lat'];

        $this_lng= $lng2/(180/\pi());
        $this_lat= $lat2/(180/\pi());


        $dist= $this->point2point_distance($longitude,$latitude,$lng2,$lat2);
        return $dist;
    }
    protected function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit='K')
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K")
        {
            return ($miles * 1.609344);
        }
        else if ($unit == "N")
        {
        return ($miles * 0.8684);
        }
        else
        {
        return $miles;
        }
    }

}
