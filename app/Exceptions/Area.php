<?php 

namespace App;

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

        if ( $req->has('pins') ) {
            $this->pins()->delete();
            foreach ($req->pins as $pin) 
                $this->storePoint($pin['lat'], $pin['lng']);
        }

        return true;
    }



    //      -- Accessors --

    public function getCoverImageAttribute() {        
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'area', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 9;
    }

}