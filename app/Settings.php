<?php
namespace App;
use Illuminate\Http\Request;
    class Settings extends BaseModel
    {
        protected $fillable=[
            'google_ads'
        ];

        protected $updated_at=false;
        protected $created_at=false;
        public $timestamps=false;

        protected $primaryKey='id';

        public function createOrEdit(Request $r)
        {
            $instance=\App\Settings::find($r['id']);
            $instance->google_ads=$r['google_ads'];
            if($instance->save())
                return response()->json("Succesifully",200);
            return response()->json('failed',405);
        }
    }



?>
