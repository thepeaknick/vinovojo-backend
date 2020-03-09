<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model {

	public $timestamps = false;

	protected $hidden = [
		'object_id', 'object_type'
	];

	protected $fillable = [
		'object_id', 'object_type', 'lat', 'lng', 'name', 'address', 'type'
	];



	//		-- Accessors --

	public function getAddressAttribute($value) {
		return ( is_null($value) ) ? '' : $value;
	}

}
