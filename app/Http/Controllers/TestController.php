<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Log;

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
        $titles= \DB::table('text_fields')->where('name','like','ADS_WINERY_ADDRESS')->get();
    }


}
