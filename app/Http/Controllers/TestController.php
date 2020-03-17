<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Log;

use Illuminate\Support\Facades\Storage;
use App\User;

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
    //         'TABLES_ADS_END_DATE'=> 'Datum zavrsetka',
    //         'TABLES_ADS_ACTIVE'=> 'Aktivno'
    //     ];
    //     $fields_en= [
    //         'TABLES_ADS_STATUS_ACTIVATED'=> 'Active',
    //         'TABLES_ADS_STATUS_DEACTIVATED'=> 'Deactivated',
    //         'TABLES_ADS_IMAGE'=> 'Image',
    //         'TABLES_ADS_NAME'=> 'Name',
    //         'TABLES_ADS_START_DATE'=> 'Start date',
    //         'TABLES_ADS_END_DATE'=> 'End date',
    //         'TABLES_ADS_ACTIVE'=> 'Active'
    //     ];
    //     $data_to_insert=[];
    //     foreach( $fields_sr as $key=>$val) {
    //         $data_to_insert[] =[
    //             'object_type'=> '29',
    //             'object_id'=> '1',
    //             'language_id'=> '1',
    //             'name'=> $key,
    //             'value'=> $val
    //         ];
    //     }
    //     foreach($fields_en as $key=>$val) {
    //         $data_to_insert[] =[
    //             'object_type'=> '29',
    //             'object_id'=> '4',
    //             'language_id'=> '4',
    //             'name'=> $key,
    //             'value'=> $val
    //         ];
    //     }

    //     $success= \DB::table('text_fields')->insert($data_to_insert);
    //     return response()->json(['success'=>$success]);
    // }


}
