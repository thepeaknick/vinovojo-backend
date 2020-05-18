<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Area extends BaseModel {

    public $timestamps = false;

    protected static $listData = [
        'areas.id', 'type', 'descriptionTrans.value as description'
    ];

    protected $fillable = [
        'name', 'description', 'type', 'parent_id'
    ];

    protected $relationships = [
        'pins', 'parent'
    ];

    public static $listRelationships = [
        'pins'
    ];

    protected $appends = [
        'cover_image'
    ];

    protected $hidden = [
        'transliterations', 'parent_id'
    ];

    public $rules = [
        'languages' => 'required|array|min:1'
    ];

    protected $storageDisk = 'areas';



    //      -- Relationships --

    public function pins() {
        return $this->hasMany('App\Pin', 'object_id')->where('object_type', $this->flag)->select('id', 'object_id', 'lat', 'lng');
    }

    public function parent() {
        $languageId = app('translator')->getLocale();
        return $this->belongsTo(static::class, 'parent_id')
                    ->select('areas.id as id', 'areas.type as type', 'areas.parent_id as parent_id', 'transliteration.value as name')
                    ->join('text_fields as transliteration', function($q) use ($languageId) {
                        $q->on('areas.id', '=', 'transliteration.object_id');
                        $q->where('object_type', $this->flag);
                        $q->where('transliteration.name', 'name');
                        if ($languageId) {
                            $q->where('language_id', $languageId);
                        }
                    });
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function wines() {
        $rel = $this->hasMany('App\Wine', 'area_id');
        $rel->where(function($q) {
            $q->where('area_id', $this->id);
            if($this->parent_id != null)
                $q->orWhere('area_id', $this->parent_id);
            if($this->parent != null)
                $q->orWhereIn('area_id', $this->parend()->pluck('id'));
        });
        return $rel;
    }



    //      -- CRUD override --

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {

        $q = parent::list($languageId, $sorting, true);

        $q->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
            $query->on('transliteration.object_id', '=', (new static)->getTable() . '.id');
            $query->where('transliteration.object_type', (new static)->flag);
            $query->where('transliteration.name', 'name');
            $query->where('transliteration.language_id', $languageId);
        });

        $q->leftJoin( (new \App\TextField)->getTable() . ' as descriptionTrans', function ($query) use ($languageId) {
            $query->on('descriptionTrans.object_id', '=', (new static)->getTable() . '.id');
            $query->where('descriptionTrans.object_type', (new static)->flag);
            $query->where('descriptionTrans.name', 'description');
            $query->where('transliteration.language_id', $languageId);
        });

        $q->addSelect('transliteration.value as name');

        return ( $getQuery ) ? $q : $q->get();

    }

    public function loadOne($id,$language){
        return $this->list($language,'asc',true)->where('areas.id',$id);
    }

    public function postCreation($req = null) {
        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        if ( $req->has('pins') )
            foreach ($req->pins as $pin) {
                $this->storePoint($pin['lat'], $pin['lng']);
            }

        return true;
    }

    public function singleDisplay($lang = null) {
        parent::singleDisplay($lang);

        if ( !is_null($this->children) )
            $this->children->transliterate($lang);

        if ( !is_null($this->parent) )
            $this->parent->transliterate($lang);

        return $this;
    }

    public function update($req = [], $options = []) {
        if ( !parent::update( $req ) )
            return false;

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        // dd($req);
        if ( $req->has('pins') ) {
            $this->pins()->delete();
            foreach ($req->pins as $pin)
                $this->storePoint($pin['lat'], $pin['lng']);
        }
        // dd($req->pins);
        return true;
    }

    public function storePoint($lat, $lng)
    {

            $point = Pin::where('object_id', $this->id)
                              ->where('object_type', $this->flag)
                              ->where('lat','=',$lat)
                              ->where('lng','=',$lng)
                              ->first();
            if ($point) {
                $point->lat = $lat;
                $point->lng = $lng;
                $point->save();
                return $point;
            }
            $point = new \App\Pin(['object_id' => $this->id, 'object_type' => $this->flag]);
            $point->lat = $lat;
            $point->lng = $lng;
            $success=$point->save();
            return true;

    }

    public function nestedDropdown($languageId=1)
    {
        $areas= static::with('parent')->where('areas.id','=',$this->id)->where('areas.parent_id')
            ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
                $query->select('transliteration.name as name');
                $query->on('transliteration.object_id', '=', (new \App\Area)->getTable() . '.id');
                $query->where('transliteration.object_type', (new \App\Area)->flag);
                $query->where('transliteration.name', 'name');
                $query->where('transliteration.language_id', $languageId);
//                        $query->select('transliteration.name','name');
                return $query;
            })->get();
        foreach ($areas as $area){
            $area->name= $area->value;
            if($area->parent !==null)
                $area->parent= $area->parent->parent;
        }
        return $areas;
    }


    //      -- Accessors --

    public function getCoverImageAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'area', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 9;
    }

    public function getClassesAttribute()
    {
        $wines = $this->wines->pluck('id')->toArray();
        $classes = DB::table('classes_wines')->whereIn('wine_id', $wines)->select('class_id')->get()->toArray();
        $ids=[];
        foreach ($classes as $class) {
            $ids[]= $class->class_id;
        }
        return array_values(array_unique($ids));
    }

    public function getHarvestYearAttribute()
    {
        $years = $this->wines->pluck('harvest_year')->toArray();
        return array_values(array_unique($years));
    }

    public function getAlcoholAttribute()
    {
        $alcohol = $this->wines->pluck('alcohol')->toArray();
        return array_values(array_unique($alcohol));
    }

    public static function dropdown($langId = null)
    {
        if($langId == null)
            $langId = 1;

        $data = parent::dropdown($langId);
        $data->each(function ($item) {
            $item->append('classes', 'harvest_year', 'alcohol');
        });
        $data->setVisible('id','name','classes', 'harvest_year', 'alcohol');
        return $data;
    }

}
