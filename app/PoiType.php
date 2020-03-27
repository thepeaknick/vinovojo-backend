<?php

    namespace App;
    use DB;
    use Illuminate\Database\Eloquent\Model;
    
    class PoiType extends BaseModel
    {
        protected $timestamps = false;
        protected $table= 'poi_type';
        protected $fillable = ['name'];
        
        
    }


?>