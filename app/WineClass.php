<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class WineClass extends BaseModel {

    protected $fillable = [
        'name', 'description'
    ];

    public $timestamps = false;

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    protected $hidden = [
        'pivot', 'transliterations'
    ];

    protected $appends= ['name'];

    public static $listData = ['wine_classes.id as id'];



    // 		-- Relationships--

    public function wines() {
        return $this->belongsToMany('App\Wine', 'classes_wines', 'class_id', 'wine_id');
    }



    // 		-- Accessors --

    public function getFlagAttribute() {
        return 4;
    }

    //      -- Wine properties
    public function getHarvestYearAttribute() {
        $year = $this->wines->pluck('harvest_year')->toArray();
        return array_values(array_unique($year));
    }

    public function getCategoriesAttribute()
    {
        $categories = $this->wines->pluck('category_id')->toArray();
        return array_values(array_unique($categories,SORT_NUMERIC));
    }

    public function getAlcoholAttribute()
    {
        $alcohol = $this->wines->pluck('alcohol')->toArray();
        return array_values(array_unique($alcohol, SORT_NUMERIC));
    }



    public static $language= 1;

    public function translate()
    {
        return $this->belongsTo('App\TextField','id','object_id')->where('object_type','=',(new static)->flag);
    }

    //      -- CRUD overrire --

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {

        $q = parent::list($languageId, $sorting, true);

        $q->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
            $query->on('transliteration.object_id', '=', (new static)->getTable() . '.id');
            $query->where('transliteration.object_type', (new static)->flag);
            $query->where('transliteration.name', 'name');
            $query->where('transliteration.language_id', $languageId);
        });

        $q->join( (new \App\TextField)->getTable() . ' as descTrans', function ($query) use ($languageId) {
            $query->on('descTrans.object_id', '=', (new static)->getTable() . '.id');
            $query->where('descTrans.object_type', (new static)->flag);
            $query->where('descTrans.name', 'description');
            $query->where('descTrans.language_id', $languageId);
        });

        $q->addSelect('transliteration.value as name');
        $q->addSelect('descTrans.value as description');

        return ( $getQuery ) ? $q : $q->paginate(10);

    }

    public function getNameAttribute()
    {
        $translation= $this->translate()->where('text_fields.name','name')->where('text_fields.language_id',1)->first();
        if($translation!==null)
            return $translation->value;
        else return null;
    }


    //      -- CRUD complements --

    public static function dropdown($langId = null)
    {
        if($langId == null)
            $langId = 1;

        $data = parent::dropdown($langId);
        $data->each(function ($item) {
            $item->append('harvest_year', 'categories', 'alcohol');
        });
        $data->setVisible('id', 'name', 'harvest_year' , 'categories', 'alcohol');

        return $data;
    }

}
