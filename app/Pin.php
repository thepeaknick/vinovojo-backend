<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model {

	public $timestamps = false;

	protected $hidden = [
		'object_id', 'object_type'
	];

	protected $fillable = [
		'object_id', 'object_type', 'lat', 'lng', 'name', 'address', 'type'
	];

	protected $appends= [
	    'logo', 'winery_id'
    ];



	//		-- Accessors --

	public function getAddressAttribute($value) {
		return ( is_null($value) ) ? '' : $value;
	}

	public function getLogoAttribute($value) {
        $data= DB::table('text_fields')->where('value','like','%'.$this->name.'%')->where('object_type',3)->first();
        if($data!=null) {
            if($this->type==3) {
                $winery= Winery::where('id',$data->object_id)->first();
                if(isset($winery) && !empty($winery) && $winery!=null)
                {
                    if($winery->logo_image)
                        return $winery->logo_image;
                }
            }
        }
        return null;
    }

    public function getWineryIdAttribute() {
        $data= DB::table('text_fields')->where('value','like','%'.$this->name.'%')->where('object_type',3)->first();
        if($data!=null) {
            if($data->object_type==3) {
                $winery= Winery::where('id',$data->object_id)->first();
                if($winery!==null)
                {
                    if($winery->id)
                        return $winery->id;
                }
            }
        }
    }


}
