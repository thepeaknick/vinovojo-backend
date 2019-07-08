<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class WineClassification extends BaseModel {

    protected $fillable = [
    	'name', 'mark', 'colour'
    ];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public $timestamps = false;

    protected $table = 'classifications';

    public static $transliteratesLists = false;

    public static $listData = [
        'id', 'name'
    ];  



    //      -- Relationships -- 



    //      -- CRUD override --

    public static function dropdown($langId = null) {
        return static::get();
    }



}
