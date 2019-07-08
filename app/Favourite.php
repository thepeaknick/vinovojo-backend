<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends BaseModel {

    public $timestamps = false;

    protected $fillable = [
        'social_id', 'object_type', 'object_id'
    ];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    protected $hidden = [
        'body'
    ];

    protected $appends = [
        'favourite_id', 'name', 'type'
    ];


    // Relationships

    public function body() {
    	if ( $this->object_type == app('App\Winery')->flag )
    		return $this->belongsTo('App\Winery', 'object_id');

    	return $this->belongsTo('App\Wine', 'object_id');
    }



    //      -- Accessors --

    public function getFavouriteIdAttribute() {
        return ( is_null($this->body) ) ? null : $this->body->id;
    }

    public function getNameAttribute() {
        return ( is_null($this->body) ) ? null : $this->body->name;
    }

    public function getTypeAttribute() {
        return ( is_null($this->body) ) ? null : $this->flag->id;
    }

}
