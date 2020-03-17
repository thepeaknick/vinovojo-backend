<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class Advertising extends BaseModel {

    protected $table= 'advertisings';
    protected $fillable = ['name','active','start_date','end_date','image_url','repeating','section'];

    protected $dates = [];



//    protected $name;
//    protected $image;
    protected static $folderPath='advertising';
    public static $rules = [
        // Validation rules
        'name'=>'required|string',
        'active'=>'',
        'start_date'=>'date_format:Y-m-d H:i:s',
        'end_date'=>'',
        'image_url'=>'',
        'repeating'=> 'string',
        'section' => 'string'
    ];
// 'in:once|always'
// 'in:startup|news|recommended|favourite|vine|winery|roads|events'
    public $timestamps = false;
    protected $created_at=false;
    protected $updated_at=false;

    protected $primaryKey='id';


    // Relationships


    // Accessors
    public function getStartTimeAttribute()
    {
        $startTime=array_pop(explode('',$this->start_date));
        return $startTime;
    }
    public static function getBasePath(){
        return Storage::disk('local')->pathPrefix();
    }

    public static function putFile($file,$name){
        return Storage::disk('local')->put(static::$folderPath.$name,$file);
    }

    public static function store(Request $r){
        $ad=new Advertising($r->all());

        $ad->start_date=( $ad->start_date!=='null' )?$ad->start_date:Carbon::now();
        $ad->end_date=( $r->end_date!=='null' )?$r->end_date:Carbon::now()->addDays(7);

        if( $ad->save() && $r->has('image_url') )
            $ad->image_url=$ad->storeImage( $ad->id,$r );
        else $ad->image_url=null;


        //$ad->active = static::checkActive( $ad->start_date,$ad->end_date );

        if($ad->save());
            return response()->json(['message'=>'ad\'s created successifully'],200);
        return response()->json(['message'=>'not found'],404);

    }

    public function storeImage($id,Request $r){
        if( $r->has('image_url') )
        {
            $name=$id.'.png';
            if( $r->hasFile('image_url') ) {
                $img=Image::make($r->image_url);
                $img->resize(1080,null,function($constraint) {
                    $constraint->aspectRatio();
                });
                $successUpload=Storage::disk('local')->path(static::$folderPath);
                $img->save($successUpload.'/'.$name);
                return $name;
            }
        }else return null;
    }

    public function isActive()
    {
        return ($this->active==1)?true:false;
    }

    public static function getAll(){
        $allData= Advertising::get();
        foreach($allData as $ads){
//            $ads->active = static::checkActive($ads->start_date,$ads->end_date);
            if(strlen($ads->image_url)<60)
            {
                $image=( $ads->image_url!==null )?url('startScreen/image/'.$ads->id):null;
                $ads->image_url=$image;
            }
        }
        return $allData;
    }

    public function deleteOldImage(){
            $img=$this->id.'.png';
            // dd($img);
            if(Storage::disk('local')->delete(static::$folderPath.'/'.$img))
                return true;
            return false;

    }

    public static function patchAds(Request $r,$id){
        $ads=\App\Advertising::find($id);
        if($ads==null)
            return response()->json(['message','not found'],404);
        if( $r->has('image_url') && $r->image_url!==NULL && $r->image_url!=='null'){
            if ( $ads->image_url!==NULL && $ads->image_url!=='null' )
            {
                if($ads->exists($ads->id))
                {
                    $ads->deleteOldImage();
                }
                $ads->image_url=$ads->storeImage( $ads->id,$r );

            }
        }
        $ads->name=$r->name;
        $ads->start_date=$r->start_date;
        $ads->end_date=$r->end_date;
        $ads->active=$r->active;
        @$ads->repeating=@$r->repeating;
        @$ads->section= @$r->section;
        if( $ads->save() )
            return response()->json(['message'=>'successifully updated'],200);
        return response()->json(['message'=>'something wen\'t wrong'],404);

    }

    public static function checkActive($start_date,$end_date) {
        $startdate=new Carbon( date($start_date) );
        $enddate=new Carbon( date($end_date) );
        $now=Carbon::now();
        // check if not expired
        if( $now->lt( $enddate ) && $now->gt($startdate) ){
          return 1;
        }
        return 0;
    }

    public function exists($id)
    {
        if(Storage::disk('local')->exists(static::$folderPath.'/'.$id.'.png'))
            return true;
        return false;
    }
    public static function loadMobile(){
        $data= Advertising::getAll();
        $allData=collect();
        foreach($data as $ad){
//            $ad->active = static::checkActive($ad->start_date,$ad->end_date);
//            $ad->save();
            if($ad->active==1 && static::checkActive($ad->start_date,$ad->end_date)){
                $ad->image_url=url('startScreen/image/'.$ad->id);
                $allData->push($ad);
            }
        }
        return $allData;
    }

    public function imagePath() {
        return Storage::disk('local')->path( static::$folderPath.'/'.$this->id.'.png' );
    }
    public function destroyAds()
    {
        $this->deleteOldImage();
        if($this->delete())
            return true;
        return false;
    }
    public function filterBySection($section,$mobile=false)
    {
        if($mobile)
            return $this->loadMobile()->where('section','=',$section);
        return static::getAll()->where('section','=',$section);
    }
    public static function correctActive()
    {

    }


}
