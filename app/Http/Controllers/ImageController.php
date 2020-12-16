<?php

namespace App\Http\Controllers;

use App\Article;

use App\Happening;
use http\Env\Request;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

        
    /**
     * Method loadCover
     *
     * @param $object $object ['wine', 'winery', ...]
     * @param $id $id [Object id]
     * @param $antiCache $antiCache
     *
     * @return file
     */
    public function loadCover($object, $id, $antiCache = null) {
        $class = '\App\\' . ucfirst($object);
        $instance = $class::find($id);

        if (!$instance)
            return response()->json("Not found", 404);

        return response()->download( $instance->coverFullPath() );
    }
    
    /**
     * Method loadLogo
     *
     * @param $object $object ['wine', 'winery']
     * @param $id $id [object id]
     * @param $antiCache $antiCache [explicite description]
     *
     * @return file
     */
    public function loadLogo($object, $id, $antiCache = null) {
        // Dynamically make object \App\Winery
        $class = '\App\\' . ucfirst($object);
        $instance = $class::find($id);

        if (!$instance)
            return response()->json("Not found", 404);

        return response()->download( $instance->logoFullPath() );
    }

    public function loadBottleImage($id, $antiCache = null) {
        $instance = \App\Wine::find($id);

        if (!$instance)
            return response()->json("Not found", 404);

        return response()->download($instance->bottleFullPath() );
    }

    public function loadAdImage(\Illuminate\Http\Request $r, $id){
        $instance = \App\Advertising::find($id);
        if(!$instance)
            return response()->json("Not found",404);

        $path = $instance->imagePath();
        \Log::error('Putanja '.$path);
        
        return response()->download( $instance->imagePath() );
    }

}
