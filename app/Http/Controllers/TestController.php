<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Log;

use Illuminate\Support\Facades\Storage;
use App\User;
use App\Winery;
use App\Wine;

use GuzzleHttp\Client;

use App\TextField;
use DB;
use FCM;
use Laravel\Socialite\Two\GoogleProvider;

class TestController extends Controller {
    public function consoleindex()
    {
        $out=[];
        $command= "cd ../../ && php artisan check:daily";
        exec($command,$out);
        dd($out);
    }
    public function index(Request $r)
    {
        dd('tu si');

        $buffer= [];
        exec('cat /home/predrag/web/ready2game.com/public_html/wp-admin/php.ini',$buffer);
        dd($buffer);
//        $imag= new \Imagick();
        print_r(phpinfo()) or die();
    }
    public function saveImage(Request $r)
    {
        dd($r->all());
        try {
            $image = Image::make($r->image);
            $image->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(\storage_path('slika.jpg'));
        } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
            return false;
        }
    }

    public function testDB(Request $r)
    {

        dd(\Storage::disk('local')->path(''));
        $titles= \DB::table('text_fields')->where('name','like','ADS_WINERY_ADDRESS')->get();
    }

    public function loadByType(Request $r, $type)
    {

        $users= User::where('social_type','=',$type)->get();
        return response()->json($users);
    }

    public function logDownload(Request $r)
    {
        $path= storage_path('logs/lumen.log');
        $file= \file_get_contents($path);
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename=log.log');
        \readfile(storage_path('logs/lumen.log'));
    }
    public function textFieldsInsert(Request $r)
    {
        $fields_sr= [
            'WINES_ADD_TEMP_SERVING_START_LABEL'=> 'Temperatura serviranja od',
            'WINES_ADD_TEMP_SERVING_END_LABEL'=> 'Temperatura serviranja do',
            'WINES_EDIT_TEMP_SERVING_START_LABEL' => 'Temperatura serviranja od',
            'WINES_EDIT_TEMP_SERVING_END_LABEL' => 'Temperatura serviranja do',
            'WINE_PREVIEW_WINE_TEMP_LABEL' => 'Temperatura serviranja'


        ];
        $fields_en= [
            'WINES_ADD_TEMP_SERVING_START_LABEL'=> 'Serving temperature from',
            'WINES_ADD_TEMP_SERVING_END_LABEL'=> 'Serving temperature to',
            'WINES_EDIT_TEMP_SERVING_START_LABEL' => 'Serving temperature from',
            'WINES_EDIT_TEMP_SERVING_END_LABEL' => 'Serving temperature to',
            'WINE_PREVIEW_WINE_TEMP_LABEL' => 'Serving temperature'
        ];
        $data_to_insert=[];
        foreach( $fields_sr as $key=>$val) {
            $one_row =[
                'object_type'=> '29',
                'object_id'=> '1',
                'language_id'=> '1',
                'name'=> $key,
                'value'=> $val
            ];

            // try{
            //     \DB::table('text_fields')->insert($one_row);
            // }catch(\Exception $e) {
            //     continue;
            // }
            $data_to_insert[] = $one_row;
        }
        foreach($fields_en as $key=>$val) {
            $one_row =[
                'object_type'=> '29',
                'object_id'=> '4',
                'language_id'=> '4',
                'name'=> $key,
                'value'=> $val
            ];

            // try{
            //     \DB::table('text_fields')->insert($one_row);
            // }catch(\Exception $e) {
            //     continue;
            // }
            $data_to_insert[]= $one_row;
        }

        $success= \DB::table('text_fields')->insert($data_to_insert);
        return response()->json(['success'=>$success]);
    }

    public function checkPath()
    {
        $data= [
            'path'=>__DIR__,
            'php'=> ''
        ];
        $out= [];
        \exec('which php', $out);
        $data['php']= $out;
        return response()->json($data);
    }

    public function textFieldsSeeder(Request $r)
    {
        // $fields= \DB::table('text_fields')->where('language_id','1')->where('object_id','1')->where('object_type','=','29')->get();
        $diff= TextField::where('object_type','=','29')->where('language_id','=','4')->where('object_id','1')->get();
        foreach($diff as $row) {
            dd($row);
            $exists_in_sr= TextField::where('object_type','=','29')->where('name',$diff->name)->where('object_id',1)->first();
            dd($exists_in_sr);
        }
        return response()->json($diff);
        // $diff= "SELECT sr.*
        //         FROM text_fields sr
        //         LEFT JOIN text_fields en
        //         ON sr.name=en.name
        //         WHERE sr.language_id=1
        //         AND en.language_id=4
        //         AND en.value IS NULL";
        // $fields= DB::select(DB::raw($diff));
        // dd($fields);
        // $string= '';
        // $file= fopen(\storage_path('strings.txt'),'a+');
        // foreach($fields as $field) {
        //     $piece= sprintf('"%s": "%s",%c', $field->name, $field->value, 0x0A);
        //     fwrite($file,$piece);
        //     // $string.=$piece;
        // }
        // \fclose($file);
        // return response()->json($string);
    }
    public function insertTable(Request $r)
    {
        // $query= "CREATE TABLE IF NOT EXISTS poi_type (id INT NOT NULL, name VARCHAR(100), PRIMARY KEY (id));";
        // $success= DB::select(DB::raw($query));
        $success= DB::table('poi_type')->insert([
            [
                'id'=> '20',
                'name'=> 'Vinoteka'
            ],[
                'id'=> '21',
                'name'=> 'Vinarija'
            ]
        ]);
        return response()->json(['message' => $success]);
    }

    public function carbonCheck(Request $r)
    {
        // dd($r->all());
        $start= new \Carbon\Carbon($r['start_date']);
        $end= new \Carbon\Carbon($r['end_date']);
        $now= \Carbon\Carbon::now();
        dd($start);
        dd($now->gt($start));
        dd($start);
    }

    public function removeDuplicates()
    {
        $dupl= [];
        foreach(\App\Highlight::orderBy('id','asc')->get() as $highlight) {
            $duplicates= \App\Highlight::where('object_id',$highlight->object_id)
                                    ->where('object_type',$highlight->object_type)
                                    ->where('type',$highlight->type)
                                    ->where('id','>',$highlight->id)
                                    ->get();
            foreach($duplicates as $duplicate) {
                $dupl[]= $duplicate;
                if($duplicate->id!==$highlight->id)
                    $duplicate->delete();
            }
        }
        return response()->json($dupl);
    }

    public function calculateRoute(Request $r)
    {
      /*
      | Override app real request
      */
      $req= app('request');
      $langId= $r->header('Accept-Language', 1);
      $limit= ($r->has('limit_points')) ? $r->limit_points : 5;
      $max_dist= ($r->has('max_distance')) ? $r->max_distance : 50000;
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

      /*
      |
      |   FILTER WINE CLASSES
      |     @parameter class_id:[]
      |
      */
      if($req->has('class_id') && !empty($req->class_id))
      {
        $q->leftJoin('wines', function($join) {
          $join->on('wines.winery_id','wineries.id');
        });
        $q->join('classes_wines', function($join) {
            $join->on('wines.id','=','classes_wines.wine_id');
        });
        try {
          $classes = json_decode($req->class_id);
        } catch (\Exception $e) {
          return response()->json(['message'=>'Field class_id must be array'], 422);
        }
        if(!is_array($classes))
          return response()->json(['message'=>'Field class_id must be array'], 422); 
        
        $q->whereIn('classes_wines.class_id', $classes);
        $q->addSelect('wines.recommended as w_rec');
      }

      $all_points= [];
      $all_distances= [];
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
        if($distance<$max_dist) 
          $all_points[]= $point;
      }

      $points=[];
      /*
      | Find the first nearest n node
      */
      usort($all_points, function($d1, $d2)use($start) {
        return $this->CalculateDistance($start, $d1) - $this->CalculateDistance($start, $d2);
      });

      /*
      | Nearest n points
      */
      $top_points = array_slice($all_points, 0, $limit, true);
      $all = [];
      /*
      | Iterate over top (N) points to find (N) ways 
      */
      // dd($top_points);
      while(count($top_points)>0)
      {
        $current_point_waypoints = [];
        $path_sum = 0;
        // currentPoint is one of (N) nearest points
        // from start point
        $currentPoint = array_shift($top_points);

        // Sum between start point and current point
        $path_sum += $this->CalculateDistance($currentPoint, $start);

        $this->reorderWaypoints($currentPoint, $all_points);
        /* 
        | Here we neet to extract all_points array except current point,
        | iterate him over (N-1) times and every time reorder array
        | to find nearest point
        */
        //  remove first element from array, because first element is current waypoint
        // We not affecting global all_points array
        $rest_waypoints = array_slice($all_points, 1, count($all_points), true);

        for($x=0; $x< $limit -1 && count($rest_waypoints); $x++) {

          // if count waypoints is larger than source count waypoints
          //  then break 
          // if(count($current_point_waypoints) > count($top_points))
          //   break;
          $current = null;
          if(count($current_point_waypoints) == 0) {
            $current = $currentPoint;
          }else {
            $current = $current_point_waypoints[count($current_point_waypoints)-1];
          }

          usort($rest_waypoints, function($x1, $x2) use($current) {
            return $this->CalculateDistance($current, $x1) - $this->CalculateDistance($current, $x2);
          });

          // We must here include current_start_waypoint
          $nearestWaypoint = array_shift($rest_waypoints);

          // Calculate distance between point and last waypoint
          if(count($current_point_waypoints) == 0)
            $path_sum += $this->CalculateDistance($currentPoint, $nearestWaypoint);
          else 
            $path_sum += $this->CalculateDistance($current_point_waypoints[count($current_point_waypoints)-1], $nearestWaypoint);

          $current_point_waypoints[] = $nearestWaypoint;
        }
        $all[] = [
          'sum' => $path_sum,
          'waypoints' => array_merge([$currentPoint], $current_point_waypoints)
        ];
      }

      // First we need to check if all array is empty
      // if(empty($all))
      if(empty($all)) {
        echo "{}";
        die();
      }

      usort($all, function($p1, $p2) {
        return $p1['sum'] - $p2['sum'];
      });

      $shortest_path= array_shift($all);
      
      $winery_ids = array_column($shortest_path['waypoints'], 'id');

      $order_string= implode(',',$winery_ids);
      $q->whereIn('wineries.id', $winery_ids);
      $q->orderByRaw(DB::raw("FIELD(wineries.id, $order_string)"));
      $q->limit($limit);
      return response()->json(['distance'=>$shortest_path['sum'], 'points'=>$q->get()]);

    }

    public function reorderWaypoints($waypoint, array &$allWaypoints)
    {
      return usort($allWaypoints, function($x1,$x2) use ($waypoint) {
        return $this->calculateDistance($waypoint, $x1)- $this->calculateDistance($waypoint, $x2);
      });
    }

    // public function CalculateDistance(array $point1, array $point2)
    // {

    //     $longitude= $point1['lng'];
    //     $latitude= $point1['lat'];

    //     //  Get longitude and latitude in radians
    //     $lng= $longitude/(180/\pi());
    //     $lat= $latitude/(180/\pi());

    //     $lng2= $point2['lng'];
    //     $lat2= $point2['lat'];

    //     $this_lng= $lng2/(180/\pi());
    //     $this_lat= $lat2/(180/\pi());


    //     $dist= $this->point2point_distance($longitude,$latitude,$lng2,$lat2);
    //     return $dist;
    // }
    public function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit='K')
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

    public function findRouteWeight($p1, $p2, $all) {

        foreach($all as $point) {

        }
    }

    public function testPointsDistance(Request $r)
    {
      if(
          !$r->has('lng1') ||
          !$r->has('lng2') ||
          !$r->has('lat1') ||
          !$r->has('lat2')
      )
        return response()->json(['message'=>'Unprocessable'], 422);

      $p1 = [
        'lng' => $r->lng1,
        'lat' => $r->lat1
      ];

      $p2 = [
        'lng' => $r->lng2,
        'lat' => $r->lat2
      ];

      $distance = $this->CalculateDistance($p1, $p2);
      return response()->json(['distance' => $distance], 200);

    }
 
    public function CalculateDistance(array $point1, array $point2) {
        $latitude1 = $point1['lat'];
        $longitude1 = $point1['lng'];

        $latitude2 = $point2['lat'];
        $longitude2 = $point2['lng'];


        $earth_radius = 6371;
     
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);
     
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
     
        return $d;
        
    }

    public function dijkstraAlgo(array $_distArr)
    {

        $a = 1;
        $b = 5;

        //initialize the array for storing
        $S = array();//the nearest path with its parent and weight
        $Q = array();//the left nodes without the nearest path
        foreach(array_keys($_distArr) as $val) $Q[$val] = 99999;
        $Q[$a] = 0;
        //start calculating
        while(!empty($Q)){
            $min = array_search(min($Q), $Q);//the most min weight
            if($min == $b) break;
            foreach($_distArr[$min] as $key=>$val)
                if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
                    $Q[$key] = $Q[$min] + $val;
                    $S[$key] = array($min, $Q[$key]);
            }
            unset($Q[$min]);
        }

        //list the path
        $path = array();
        $pos = $b;
        while($pos != $a){
            $path[] = $pos;
            $pos = $S[$pos][0];
        }
        $path[] = $a;
        $path = array_reverse($path);

        //print result
        // echo "<img src='http://www.you4be.com/dijkstra_algorithm.png'>";
        echo "<br />From $a to $b";
        echo "<br />The length is ".$S[$b][1];
        echo "<br />Path is ".implode('->', $path);
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
