<?php

namespace App\Http\Controllers;

use App\Wine;

use App\Article;

use App\Happening;

use App\Advertising;

// use http\Env\Request;

use Illuminate\Http\Request;

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
        $instance = Wine::find($id);

        if (!$instance)
            return response()->json("Not found", 404);

        return response()->download($instance->bottleFullPath() );
    }

    public function loadAdImage(Request $r, $id){
        $instance = Advertising::find($id);
        if(!$instance)
            return response()->json("Not found",404);

        $path = $instance->imagePath();
        \Log::error('Putanja '.$path);
        
        return response()->download( $instance->imagePath() );
    }

}
