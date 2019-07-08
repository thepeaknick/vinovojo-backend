<?php 

namespace App;

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

    public static $listData = ['wine_classes.id as id'];



    // 		-- Relationships-- 

    public function wines() {
    	return $this->belongsToMany('App\Wine', 'classes_wines', 'class_id', 'wine_id');
    }



    // 		-- Accessors --

    public function getFlagAttribute() {
    	return 4;
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


    //      -- CRUD complements --

    

}
