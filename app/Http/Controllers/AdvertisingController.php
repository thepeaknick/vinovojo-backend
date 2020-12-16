<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Advertising;

class AdvertisingController extends Controller {

    const MODEL = "App\AdsController";

    //use RESTActions;

    public function store(Request $r){
        return Advertising::store($r);
    }


    public function all(){
        $data= Advertising::getAll();
        if($data)
            return $data->paginate(10);
    }

    public function patchAds(Request $r,$id){
        if($r->has('id') || isset($id))
            return \App\Advertising::patchAds($r,$id);
        else return response()->json(['message'=>'not found'],404);
    }

    public function patchAdsMobile(Request $r){
//        \App\Advertising::correctActive();
        $data= Advertising::loadMobile();
        if($data){
            return response()->json($data,200);
        }
        else return response()->json(['message'=>'something went wrong'],404);
    }

    public function deleteAds(Request $r,$id)
    {
        $ads= Advertising::findOrFail($id);
        if($ads->destroyAds())
            return response()->json("Successifully deleted",200);
        return response()->json("Failed!",404);
    }
        
    /**
     * Method loadBySection
     *
     * @param Request $r []
     * @param $section $section ['ads']
     *
     * @return json
     */
    public function loadBySection(Request $r,$section)
    {
        $mobile=strpos($_SERVER['REQUEST_URI'],'mobile');
        $advert=new Advertising;
        $ads=$advert->filterBySection($section,$mobile);
        return response()->json($ads,200);
    }


}
