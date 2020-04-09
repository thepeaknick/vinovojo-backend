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
            'EVENTS_ACTIVE_LABEL'=> 'Aktivno',
            'EVENTS_ACTIVE_HINT'=> 'Nakon isteka datuma završetka, dešavanje će se automatski deaktivirati'


        ];
        $fields_en= [
            'EVENTS_ACTIVE_LABEL'=> 'Active',
            'EVENTS_ACTIVE_HINT'=> 'After time has expired, event will be deactivated'
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

            try{
                \DB::table('text_fields')->insert($one_row);
            }catch(\Exception $e) {
                continue;
            }
            // $data_to_insert[] = $one_row;
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
      $limit= ($r->has('limit_points'))?$r->limit_points:100;
      $max_dist= ($r->has('max_distance'))?$r->max_distance:50000;
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
            $q->where('wines.id','=','classes_wines.wine_id');
        });
        $q->where('classes_wines.class_id', $req->class_id);
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
        if($distance<$max_dist) {
          // $all_distances[] = $distance;
          $all_points[]= $point;
        }
      }
      // for($x=0;$x<count($all_points);$x++) {
      //     for($y=$x;$y<count($all_points);$y++) {
      //         $all_distances[$x][$y]= $this->CalculateDistance($all_points[$x], $all_points[$y]);
      //     }
      // }
      // die();
      // $this->dijkstraAlgo($all_distances);
      //die();
      $points=[];
      /*
      | Find the first nearest node
      */
      usort($all_points, function($d1, $d2)use($start) {
        return $this->CalculateDistance($start, $d1)-$this->CalculateDistance($start, $d2);
      });
      // $current_node= array_shift($all_points);
      // $points[] = $current_node['id'];
      /*
      |-------------------------------------------------------------
      | Do it untill point length is smaller than requested number
      | of points
      */
      $distance= [];
      $matrix= [];
      $visited= [];
      $time=0;

      $all_distances= [];
      for($x=0;$x<(count($all_points)-1); $x++) {
          for($y=0;$y<(count($all_points)-1); $y++) {
              // print_r($x,$y);
              if($x!==$y) {
                  // $point= [
                  //     'from'=> $all_points[$x]['id'],
                  //     'to' => $all_points[$y]['id'],
                  //     'distance' => $this->CalculateDistance($all_points[$x], $all_points[$y])
                  // ];
                  // $all_distances[]= $point;
                  $all_distances[$all_points[$x]['id']][$all_points[$y]['id']]= $this->CalculateDistance($all_points[$x], $all_points[$y]);
              }
              usort($all_distances[$all_points[$x]['id']][$all_points[$y]['id']], function($x1,$x2) {
                  return $x1-$x2;
              })
          }
      }
      dd($all_distances);

      for($x=0; $x<count($all_points) && count($points)<$limit; $x++) {
          $current_node= $all_points[$x];
          array_push($visited, $current_node['id']);
          usort($all_points, function($d1,$d2)use($current_node) {
            return $this->CalculateDistance($current_node, $d1)- $this->CalculateDistance($current_node, $d2);
          });
          $points[]= $new_point= array_shift($all_points)['id'];
        }

        $order_string= implode(',',$points);
      $q->whereIn('wineries.id', $points);
      $q->orderByRaw(DB::raw("FIELD(wineries.id, $order_string)"));
      $q->limit($limit);
      return response()->json(['time'=>$time, 'points'=>$q->get()]);

      // return response()->json(['distances'=> $points, 'wineries'=> $q->get(), 'time'=> $time]);
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

    public function CalculateDistance(array $point1, array $point2)
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
