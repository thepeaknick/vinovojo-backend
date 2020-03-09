<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WineType extends BaseModel {

	protected $fillable = [
        'colour'
    ];

    public $timestamps = false;

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    protected $hidden = [
        'pivot', 'transliterations'
    ];

    public static $listData = ['wine_types.id as id', 'wine_types.colour as colour'];

//    public $appends=['name'];
        // 		-- Accessors --

    public function getFlagAttribute() {
    	return 30;
    }

	public function wines() {
		return $this->hasMany(\App\Wine::class);
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

//    public function getNameAttribute()
//    {
//        return \App\TextField::where('object_id',$this->id)->where('object_type',$this->flag);
//    }

    public function transliterate($languageId=null,$attributes=[]) {
        $transliterations= $this->transliterations()->where('text_fields.language_id',$languageId)->where('text_fields.object_id',$this->id)->get();
        foreach ($transliterations as $transliteration) {
            if($transliteration->name=='name') {
                $this->attributes['name']= $transliteration->value;
            }
        }
//        if($name!=null)
//            return $name;
//        return null;
    }


}
