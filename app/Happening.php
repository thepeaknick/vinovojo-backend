<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Http\Parser\QueryString;
use LaravelFCM\Request\Request;

class Happening extends BaseModel {

    protected static $listData = [
        'events.id as id', 'start', 'end', 'location', 'link', 'lat', 'lng', 'created_at', 'nameTransliteration.value as name', 'textTransliteration.value as description'
    ];

    // public static $listTransliteration = [
    //     'name', 'description'
    // ];

    protected $fillable = [
        'name', 'description', 'start', 'end', 'location', 'lat', 'lng', 'link', 'active'
    ];

    protected $appends = [
    	'image_path', 'flag'
    ];

    protected $hidden = [
        'transliterations'
    ];

    protected $storageDisk = 'events';

    protected $table = 'events';

    protected $rules = [
        'start' => 'date|required',
        'end' => 'date|required',
        'link' => 'URL',
        'lat' => 'numeric|required',
        'long' => 'numeric|required',
        'location' => 'string|required'
    ];

    public static $listSort = 'start';


    //      -- Accessors --

    public function getImagePathAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'happening', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 0;
    }



    //      -- CRUD override --

    public static function list($lang, $sorting = 'desc', $getQuery = false) {
        parent::$listSort='events.start';
        // parent::$sorting='asc';
        // $q = parent::list($lang, $sorting, true);
        $q = parent::list($lang, $sorting, true,'')
                    ->join('text_fields as nameTransliteration', function ($q) use ($lang) {
                            $q->on('nameTransliteration.object_id', '=', 'events.id');
                            $q->where('nameTransliteration.object_type', (new static)->flag);
                            $q->where('nameTransliteration.name', 'name');
                            $q->where('nameTransliteration.language_id', $lang);
                        })
                    ->leftJoin( 'text_fields as textTransliteration', function ($q) use ($lang) {
                            $q->on('textTransliteration.object_id', '=', 'events.id');
                            $q->where('textTransliteration.object_type', (new static)->flag);
                            $q->where('textTransliteration.name', 'description');
                            $q->where('textTransliteration.language_id', $lang);
                    });
        // var_dump($q instanceof \Illuminate\Database\Eloquent\Builder);

        // var_dump($q->toSql());
        // die();

        // $q->latest('start');
        return ($getQuery) ? $q : $q->paginate(10);
    }

    public function postCreation($req = null) {
        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        return true;
    }


    public function update($req = [], $options = []) {
        if ( !parent::update($req) )
            return response()->json(['error ' => 'Something went wrong'], 500);

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        return response(null, 204);
    }

    public static function searchSorted($id=0)
    {
        $all=DB::table('events')->select()->orderBy( static::$listSort , 'desc' )->get();

        // dd($all);
        if( count( $all ) && $id)
        {
            return new \App\Happening((array)$all[$id-1]);
        }else{
            return $all;
        }
        return null;
    }

}
