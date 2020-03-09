<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class WinePath extends BaseModel {

    protected $table = 'routes';

    public $timestamps = false;

    protected $fillable = [
        'name', 'start_lat', 'start_lng', 'end_lat', 'end_lng', 'start_name', 'start_address', 'end_name', 'end_address'
    ];

    protected $hidden = [
        'transliterations', 'start_id', 'end_id'
    ];

    protected $appends = [
    	'cover_image'
    ];

    protected $relationships = [
        'waypoints', 'start', 'end'
    ];

    protected $storageDisk = 'paths';

    protected static $listData = [
        'routes.id as id', 'nameTransliteration.value as name'
    ];



    //      -- Relationships --

    public function waypoints() {
        return $this->hasMany('App\Pin', 'object_id')
                    ->where('object_type', $this->flag)
                    ->where('id', '!=', $this->start_id)
                    ->where('id', '!=', $this->end_id);
    }

    public function start() {
        return $this->belongsTo('App\Pin', 'start_id');
    }

    public function end() {
        return $this->belongsTo('App\Pin', 'end_id');
    }



    //		-- Accessors --

    public function getAddressAttribute($value) {
        if ( is_null($value) )
            return '';
        return $value;
    }

    public function getCoverImageAttribute() {
    	return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'winePath', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 12;
    }



    //      -- Custom methods --



    //      -- CRUD override --

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {
        $q = parent::list($languageId, $sorting, true)
                    ->join('text_fields as nameTransliteration', function ($q) use ($languageId) {
                            $q->on('nameTransliteration.object_id', '=', 'routes.id');
                            $q->where('nameTransliteration.object_type', (new static)->flag);
                            $q->where('nameTransliteration.name', 'name');
                            $q->where('nameTransliteration.language_id', $languageId);
                        });


        if ($getQuery)
            return $q;

        $data = $q->paginate(10);

        $data->getCollection()->makeHidden(['start', 'end']);

        return $data;
    }

    public function preCreate($req) {
        if ( !$req->has(['start', 'end']) )
            return false;

        $start = app('App\Pin')->fill($req->start);
        $start->object_type = $this->flag;
        $start->object_id = 1;

        $end = app('App\Pin')->fill($req->end);
        $end->object_type = $this->flag;
        $end->object_id = 1;

        if ( !$start->save() || !$end->save() )
            return false;

        $this->start_id = $start->id;
        $this->end_id = $end->id;

        return true;
    }

    public function postCreation($req = null) {
        if ( $req->has('waypoints') )
            foreach ($req->waypoints as $wp) {
                $pin = new \App\Pin($wp);
                $pin->object_type = $this->flag;
                $pin->object_id = $this->id;
                $pin->fill($wp);
                if ( !$pin->save() )
                    return false;
            }

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        $this->start->update(['object_id' => $this->id]);
        $this->end->update(['object_id' => $this->id]);

        return true;
    }

    public static function search($param, $languageId, $getQuery = false) {
        $query = parent::search($param, $languageId, true);

        if ($getQuery)
            return $query;

        $data = $query->paginate(10);
        $data->getCollection()->makeHidden(['start', 'end'])->transliterate($languageId);

        return $data;
    }

    public function update($req = [], $options = []) {
        if ( !parent::update($req) )
            return false;

        if ( $req->has('waypoints') ) {
            $this->waypoints()->delete();
            foreach ($req->waypoints as $wp) {
                $point = app('App\Pin');
                $point->fill($wp);
                $point->object_id = $this->id;
                $point->object_type = $this->flag;
                if ( !$point->save() )
                    return false;
            }
        }

    if ( $req->hasFile('cover') )
        $this->storeCover($req->cover);

    if ( $req->has('start') )
        if ( !$this->start->update($req->start) )
            return false;

    if ( $req->has('end') )
        if ( !$this->end->update($req->end) )
            return false;

    return true;

    }

}
