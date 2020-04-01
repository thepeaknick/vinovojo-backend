<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Log;

use Illuminate\Support\Facades\Storage;
use App\User;

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
            'POI_DROPDOWN_TYPES_LABEL'=> 'Tip tačke od interesa',
            'ADS_ADD_TITLE'=> 'Marketing',
            'ADS_EDIT_TITLE'=> 'Marketing',
            'ADS_DROPDOWN_ITEM_NEWS'=> 'Vesti',
            'ADS_DROPDOWN_ITEM_RECOMMENDED'=> 'Preporučeno',
            'ADS_DROPDOWN_ITEM_FAVOURITE'=> 'Omiljeno',
            'ADS_DROPDOWN_ITEM_WINE'=> 'Vina',
            'ADS_DROPDOWN_ITEM_WINERY'=> 'Vinarije',
            'ADS_DROPDOWN_ITEM_ROADS'=> 'Putevi',
            'ADS_DROPDOWN_ITEM_EVENTS'=> 'Desavanja',

            'ADS_DROPDOWN_ITEM_ALWAYS'=> 'Stalno',
            'ADS_DROPDOWN_ITEM_ONCE'=> 'Jednom'

        ];
        $fields_en= [
            'POI_DROPDOWN_TYPES_LABEL'=> 'Poi type',
            'ADS_ADD_TITLE'=> 'Marketing',
            'ADS_EDIT_TITLE'=> 'Marketing',
            'ADS_DROPDOWN_ITEM_NEWS'=> 'News',
            'ADS_DROPDOWN_ITEM_RECOMMENDED'=> 'Recommended',
            'ADS_DROPDOWN_ITEM_FAVOURITE'=> 'Favourite',
            'ADS_DROPDOWN_ITEM_WINE'=> 'Wine',
            'ADS_DROPDOWN_ITEM_WINERY'=> 'Winery',
            'ADS_DROPDOWN_ITEM_ROADS'=> 'Roads',
            'ADS_DROPDOWN_ITEM_EVENTS'=> 'Events',

            'ADS_DROPDOWN_ITEM_ALWAYS'=> 'Always',
            'ADS_DROPDOWN_ITEM_ONCE'=> 'Once'


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




}
