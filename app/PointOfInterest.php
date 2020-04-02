<?php

namespace App;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

class PointOfInterest extends BaseModel {

    protected $table = 'pois';

	public $timestamps = false;

    protected $fillable = [
        'address', 'type'
    ];

    protected $hidden = [
    	'location', 'transliterations'
    ];

    protected $appends = [
    	'lat', 'lng', 'cover_image'
    ];

    protected $relationships = [
        'location'
    ];

    protected static $listRelationships = [
        'location'
    ];

    protected static $listData = [
        'pois.id as id', 'pois.address as address', 'pois.type as type'
    ];

    protected $storageDisk = 'pois';



    //		-- Accessors --

    public function getLngAttribute() {
        if ( is_null($this->location) )
            return null;
    	return $this->location->lng;
    }

    public function getLatAttribute() {
        if ( is_null($this->location) )
            return null;
    	return $this->location->lat;
    }

    public function getFlagAttribute() {
        return 8;
    }

    public function getCoverImageAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'pointOfInterest', 'id' => $this->id]) : null;
    }



    //		-- Relationships --

    public function location() {
    	return $this->hasOne('App\Pin', 'object_id')->where('object_type', $this->flag);
    }

    public function type() {
        return $this->hasOne('App\PoiType', 'id')->where('id', $this->type);
    }



    //      -- CRUD override --

    public function postCreation($req = null) {
        $point = new Pin($req->only(['lat', 'lng']));
        $point->object_id = $this->id;
        $point->object_type = $this->flag;
        return $point->save();
    }

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {
        $req= app('request');
        $sort= $req->header('Sorting','asc');

        $q = parent::list($languageId, $sorting, true);
        $q->join( (new TextField)->getTable() . ' as transliterations', function ($query)use($languageId) {
            $query->on('transliterations.object_id', '=', (new static)->getTable() . '.id');
            $query->where('transliterations.object_type', (new static)->flag);
            $query->where('transliterations.name', 'name');
            // $query->where('transliterations.language_id',$languageId);
        });

        $q->join('poi_type',function($join) {
            $join->on('poi_type.id','=','pois.type');
        });
        $q->addSelect('poi_type.name as poi_type');
        $q->addSelect('poi_type.name as type');
        $q->addSelect('poi_type.type as poi_type_id');
        $q->addSelect('transliterations.value as name');

        if($req->has('search')) {
            $q->where('transliterations.value','like','%'.$req->search.'%')
                ->orWhere('address','like','%'.$req->search.'%');
        }

        if(!empty($req->header('SortPoi')) && $req->header('SortPoi')!=='asc')
        {

            $column= $req->header('SortPoi');
            if($column=='type'){
                $q->orderBy('poi_type', $sort);
            }else {
                $q->orderBy($column, $sort);
            }
        }
        if ($getQuery)
            return $q;

 
        // dd($q->toSql());

        $pois = $q->get();

        // Add default language for winery list
        $languageId= ($languageId!=null)?$languageId:'1';

        $wineries = Winery::list($languageId, $sorting, true,'');
        $wineries->join('pins', function($query) {
            $query->on('pins.object_id', '=', 'wineries.id');
            $query->where('pins.object_type', (new \App\Winery)->flag);
//            $query->where('pins.object_type','!=', (new \App\Pin)->flag);
        });

        $wineries = $wineries->select('wineries.id as id', 'transliteration.value as name', 'pins.lat as lat', 'pins.lng as lng', 'wineries.address as address')->get();
        $wineries->transform( function($w) {
            $w->type = $w->flag;
            $w->makeHidden('flag');
            return $w;
        });
        $data = $pois->merge($wineries);

        $data->makeHidden(['cover_image', 'video', 'rate', 'rate_count']);

        $data = ( $sorting == 'asc' ) ? $data->sortBy('name') : $data->sortByDesc('name');

        return $data->values();
    }

    public function update($req = [], $options = []) {
        if ( !parent::update($req) )
            return false;

        $this->location()->update( $req->only(['lat', 'lng']) );

        return true;
    }

    public static function search($param, $languageId, $getQuery = false) {
        $query = parent::search($param, $languageId, true);
        $selects = (new static)->getTable() . '.*, transliteration.value as name';
        $query->select( app('db')->raw($selects) );
        $query->with('location');
        $query->orWhere('address', 'like', "%{$param}%");
        return ($getQuery) ? $query : $query->paginate();
    }



    //      -- Custom methods --

    public static function filterByDistance($langId, $lat, $long, $getQuery = false) {
        $q = static::list($langId, 'asc', true);

        $q->leftJoin('pins', function ($q) {
            $q->on( 'pins.object_id', '=', 'pois.id' );
            $q->where( 'pins.object_type', (new static)->flag );
        });

        $distanceCalculation = "( 111.111 * DEGREES(ACOS(COS(RADIANS(pins.lat))
                          * COS(RADIANS({$lat}))
                          * COS(RADIANS(pins.lng - {$long}))
                          + SIN(RADIANS(pins.lat))
                          * SIN(RADIANS({$lat})))) )";

        $q->addSelect( app('db')->raw($distanceCalculation . ' as distance') );

        return ($getQuery) ? $q : $q->get();

    }

}
