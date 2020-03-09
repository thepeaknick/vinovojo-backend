<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextField extends Model {

	public $timestamps = false;

    protected $fillable = [
        'object_id', 'object_type', 'language_id', 'name', 'value'
    ];

    protected $hidden = [
    	'object_id', 'object_type', 'language_id'
    ];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];



    // Relationships

    public function language() {
    	return $this->belongsTo('\App\Language')->select('id', 'name');
    }



    //      -- Accessors --

    public function getFlagAttribute() {
        return 19;
    }



    //      -- CRUD Override --

    public static function list($languageId, $getQuery = false) {
        $q = static::join('languages', 'languages.id', '=', 'text_fields.language_id')
                   ->groupBy('language_id')
                   ->select('text_fields.id as id', 'languages.name as language');

        return ( $getQuery ) ? $q : $q->get();
     }

}
