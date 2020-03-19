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
    // public function textFieldsInsert(Request $r)
    // {
    //     $fields_sr= [
    //         'TABLES_ADS_STATUS_ACTIVATED'=> 'Aktivno',
    //         'TABLES_ADS_STATUS_DEACTIVATED'=> 'Neaktivno',
    //         'TABLES_ADS_IMAGE'=> 'Slika',
    //         'TABLES_ADS_NAME'=> 'Naziv',
    //         'TABLES_ADS_START_DATE'=> 'Datum početka',
    //         'TABLES_ADS_END_DATE'=> 'Datum završetka',
    //         'TABLES_ADS_ACTIVE'=> 'Aktivno',
    //         'WINE_PATH_ADD_SEARCH_WINERY_LABEL'=> 'Pretraži vinarije iz baze'
    //     ];
    //     $fields_en= [
    //         'TABLES_ADS_STATUS_ACTIVATED'=> 'Actived',
    //         'TABLES_ADS_STATUS_DEACTIVATED'=> 'Deactivated',
    //         'TABLES_ADS_IMAGE'=> 'Image',
    //         'TABLES_ADS_NAME'=> 'Name',
    //         'TABLES_ADS_START_DATE'=> 'Start date',
    //         'TABLES_ADS_END_DATE'=> 'End date',
    //         'TABLES_ADS_ACTIVE'=> 'Active',
    //         'WINE_PATH_ADD_SEARCH_WINERY_LABEL'=> 'Search wineries from database'
    //     ];
    //     $data_to_insert=[];
    //     foreach( $fields_sr as $key=>$val) {
    //         $one_row =[
    //             'object_type'=> '29',
    //             'object_id'=> '1',
    //             'language_id'=> '1',
    //             'name'=> $key,
    //             'value'=> $val
    //         ];

    //         try{
    //             \DB::table('text_fields')->insert($one_row);
    //         }catch(\Exception $e) {
    //             continue;
    //         }
    //         // $data_to_insert[] = $one_row;
    //     }
    //     foreach($fields_en as $key=>$val) {
    //         $one_row =[
    //             'object_type'=> '29',
    //             'object_id'=> '4',
    //             'language_id'=> '4',
    //             'name'=> $key,
    //             'value'=> $val
    //         ];

    //         try{
    //             \DB::table('text_fields')->insert($one_row);
    //         }catch(\Exception $e) {
    //             continue;
    //         }
    //         // $data_to_insert[]= $one_row;
    //     }

    //     $success= \DB::table('text_fields')->insert($data_to_insert);
    //     return response()->json(['success'=>$success]);
    // }

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


}
