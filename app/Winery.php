<?php

namespace App;

use DB;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManagerStatic as Image;

class Winery extends BaseModel {

    protected $fillable = [
        'address', 'recommended', 'background', 'webpage', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday','saturday', 'sunday', 'area_id', 'contact_person', 'contact', 'name', 'description', 'highlighted', 'admin_id'
    ];

    protected $hidden = [
        'area_id', 'transliterations', 'rates'
    ];

    protected static $listData = [
        'wineries.id as id', 'wineries.address as address', 'recommended', 'transliteration.value as name', 'wineries.highlighted as highlighted'
    ];

    protected $appends = [
        'flag', 'cover_image', 'logo_image', 'video', 'working_time', 'rate', 'rate_count'
    ];

    protected $storageDisk = 'wineries';

    protected $relationships = [
        'rates', 'categories', 'area', 'availableLanguages', 'pin', 'gallery', 'admin'
    ];

    public $rules = [
        'address' => 'string|required',
        // 'monday' => 'present',
        // 'tuesday' => 'present',
        // 'wednesday' => 'present',
        // 'thursday' => 'present',
        // 'friday' => 'present',
        // 'saturday' => 'present',
        // 'sunday' => 'present',
        'area_id' => 'numeric',
        'languages' => 'array|min:1|required'
    ];

    protected static $flag=2;



    //      -- Relationships --

    public function gallery() {
        return $this->hasMany('App\File')->orderBy('position', 'asc');
    }

    public function rates() {
        return $this->hasMany('App\Rate', 'object_id')->where('object_type', $this->flag)->latest('created_at');
    }

    public function approvedRates() {
        return $this->rates()->where('status', 'approved')->whereNotNull('rates.rate');
    }

    public function categories() {
        $relation = $this->hasMany('App\Wine')->select('wine_categories.id as id', 'wines.winery_id as winery_id', 'transliteration.value as name')
                                        ->join('wine_categories', 'wine_categories.id', '=', 'wines.category_id')

                                        ->join('text_fields as transliteration', function ($q) {
                                            $q->on('transliteration.object_id', '=', 'wine_categories.id');
                                            $q->where('transliteration.object_type', (new \App\Category)->flag);
                                            $q->where('transliteration.name', 'name');
                                        })

                                        ->groupBy('id');
        return $relation;
    }

    public function area() {
        $languageId = app('translator')->getLocale();
        // dd($languageId);
        $area= $this->belongsTo('App\Area')->select('areas.id as id', 'transliteration.value as name', 'areas.type as type', 'areas.parent_id as area_parent_id')
                        ->join('text_fields as transliteration', function ($q) use ($languageId) {
                            $q->on('areas.id', '=', 'transliteration.object_id');
                            $q->where('object_type', (new \App\Area)->flag);
                            $q->where('transliteration.name', 'name');
                            // if ($languageId) {
                                // $q->where('language_id', $languageId);
                            // }
                         });
        // $req= app('request');
        // if($req->has('SortBy') && $req->SortBy=='area_name') {
        //     $order= ($req->SortBy=='')
        // }
        return $area;
    }

    public function pin() {
        return $this->hasOne('App\Pin', 'object_id')->where('object_type', $this->flag);
    }

    public function admin() {
        return $this->belongsToMany('App\User');
    }


    public static function listWithLiked($language,$sorting= 'asc', $getQuery=false, $search='',$orderBy='') {
        if(app('auth')->user()!==NULL) {
            $data=static::list($language,$sorting,true,$search,$orderBy)->get();
            // dd($data);
            $allData=collect();
            foreach($data as $winery) {
                $marketing=new \App\Highlight();
                //Q$marketing->checkAndModify($winery->id,(new static)->flag);
                $exists=\App\Favourite::where('object_id','=',$winery->id)->where('favourites.object_type', '=', '2')->first();
                // dd($data[0]);
                if($exists!==NULL){
                    // array_merge($data[$i],['liked'=>1]);
                    // $data[$i]->merge(['liked'=>1]);
                    $winery->push('liked',1);
                    $winery->liked=1;
                    $winery['liked']=1;
                }

                else {
                    $winery->push('liked',0);
                    $winery->liked=0;
                    $winery['liked']=0;
                    // $data[$i]['liked']=0;
                }
                $allData->push($winery->toArray());
                // dd($arr);
            }
            // dd($data);
            return ($getQuery)?$allData:$allData->paginate(10);
        }
        else return static::list($language,$sorting,$getQuery,$search,$orderBy);
    }


    //      -- CRUD override --

    public static function list($lang, $sorting = 'asc', $getQuery = false,$search='') {
        $q = static::select( static::$listData );

        // $q->addSelect( app('db')->raw( "avg(rates.rate) as rate, count(IFNULL(rates.id,'')) as rate_count" ) );
        // $q->addSelect('areaTransliteration.value as area');
        $q->addSelect('wineries.area_id as area_id');

        // $q->with('area');
        $q->with('area');
        // $q->with('area.parent');

        $q->leftJoin('rates', function ($q) {
            $q->on('wineries.id', '=', 'rates.object_id');
            $q->where('rates.object_type', (new static)->flag );
            $q->where('rates.status', 'approved');
            // $q->addSelect(app('db')->raw("avg(IIF(rates.status LIKE approved)rates.rate as rate), count(IFNULL(rates.id,'')) as rate_count"));
        });
        // print_r($q->toSql());die();
        $q->with('pin');

        $q->join('text_fields as transliteration', function ($q) use ($lang,$search) {
            $q->on('wineries.id', '=', 'transliteration.object_id');
            $q->where('transliteration.object_type', (new static)->flag);
            $q->where('name', 'name');
            $q->where('transliteration.language_id', $lang);
            $q->where('transliteration.value','like','%'.rtrim($search.'%',' ').'%');
        });

        //  Handle filter
        $req= app('request');
        if($req->has('search')){
            $q->where('transliteration.value','like','%'.$req->search.'%');
        }

        if($req->has('winery_id'))
            $q->where('wineries.id','=',$req->winery_id);


        // if ( $req->has('area_id') )
        // {
        //     $area_ids=[];
        //     $area= Area::where('id',$req->area_id)->first();
        //     if($area!==null) {
        //         $area_ids[] =$area->id;
        //         if($area->parent_id!=null)
        //         {
        //             $area_ids[]= $area->parent_id;
        //             $parent= Area::where('id',$area->parent_id)->first();
        //             if($parent->parent_id!==null)
        //                 $area_ids[]= $parent->parent_id;
        //         }
        //     }
        //     $q->whereIn('wineries.area_id', array_unique($area_ids));
        // }

        if ( $req->has('area_id') )
        {
            $area_ids=[];
            // dd($req->area_id);
            $area_id= $req->area_id;
            $query="
            SELECT
                a.id as a_id,
                p_a.id as p_id,
                pp_a.id as pp_id
            FROM areas a
            INNER JOIN areas p_a
                ON a.parent_id=p_a.id
            INNER JOIN areas pp_a
                ON p_a.parent_id= pp_a.id
            WHERE a.id= $area_id
            OR p_a.id= $area_id
            OR pp_a.id= $area_id
        ";
            $areas= DB::select(DB::raw($query));
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wineries.area_id', array_unique($area_ids));
        }
        // $sortBy = $req->header('Sort-By', static::$listSort);
        // dd($req->header('SortBy'));
        if(!empty($req->header('SortBy')) && $req->header('SortBy')!=='asc')
        {
            $sort= $req->header('Sorting','asc');
            if($req->header('SortBy')=='region') {
                // $sort= ($sort==1)?'asc':'desc';
                $q->join('areas','wineries.area_id','areas.id')
                    ->leftJoin('text_fields as areaTransliteration',function($join) {
                        $join->on('areaTransliteration.object_id','=','areas.id');
                        $join->where('areaTransliteration.object_type',(new \App\Area)->flag);
                        $join->where('areaTransliteration.name','name');
                    });
                $q->addSelect('areaTransliteration.value as area_name');
                $q->orderBy('area_name', $sort);
            }else {
                $q->orderBy($req->header('SortBy'), $sort);
            }
        }

        if($req->has('sort')) {
            $q->orderBy('rates.rate',$sorting);
            // $q->orderByRaw( 'CAST(rate as FLOAT) '.$sorting);
        }
        // print_r($q->toSql());die();
        $q->groupBy('wineries.id');
        if ($getQuery)
            return $q;
        $data = $q->paginate(10);
        foreach ($data as $singleData) {
            $marketing=new \App\Highlight();
            //$marketing->checkAndModify($singleData->id,(new static)->flag);
            if(isset($instance->search_count))  {
                $singleData->search_count=$singleData->approvedRates()->whereNotNull('rates.rate')->groupBy('id')->get()->count();
                $singleData->rate_count=\App\Rate::where('object_id',$singleData->id)->where('rates.status','=','approved')->whereNotNull('rates.rate')->get()->count();
//                dd($singleData);
            }
        }
        $data->getCollection()->transform(function($winery) {
            if ($winery->area) {
                if ($winery->area->parent) {
                    $winery->area->parent->parent;
                }
            }
            return $winery;
        });
        $data->makeHidden('video');

        return $data;
    }

    public function singleDisplay($languageId = null) {

        parent::singleDisplay();
        $this->categories->transform( function ($cat) {
            $cat->setAppends([]);
            $cat->cover = route('cover_image', ['object' => 'category', 'id' => $cat->id]);
            return $cat;
        });


        $this->comments = $this->approvedRates()->with('user')->limit(3)->get();

        $areas= \App\Area::with('parent')->where('areas.id','=',$this->area_id)
            ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
                $query->select('transliteration.name as name');
                $query->on('transliteration.object_id', '=', (new \App\Area)->getTable() . '.id');
                $query->where('transliteration.object_type', (new \App\Area)->flag);
                $query->where('transliteration.name', 'name');
                $query->where('transliteration.language_id', $languageId);
//                        $query->select('transliteration.name','name');
                return $query;
            })->get();
        foreach ($areas as $area){
            $area->name= $area->value;
            $area->parent= $area->parent->parent;
        }
        $this->areas=$areas;


//        $this->rate_count=\DB::table('rates')->where('object_id','=',$this->id)->where('status','=','approved')->wherenotNull('rate')->count();
//        $this->rate_count=$this->approvedRates()->whereNotNull('rate')->groupBy('id')->get()->count();
//        $this->rate_count = $this->approvedRates()->count();
//        $this->rate = $this->approvedRates()->avg('rate');

        $search = app('request')->header('Pragma');
        if ( !is_null($search) && $search == 'search' ) {
            $this->incrementSearch();
        }

        if (Auth::user())
            $this->user_rates = $this->rates()->where('user_id', Auth::user()->id)->where('status', 'hold')->get();

        return $this;
    }

    public function validatesBeforeCreation() {
        return true;
    }

    public function getRules() {
        $rules = $this->rules;
        $rules['area_id'] .= '|' . \Illuminate\Validation\Rule::exists('areas', 'id');//->where('type', 'regija')
        return $rules;
    }

    public function update($req = [], $options = []) {
        $this->fill( $req->only( $this->getFillable() ) );
        if ( !$this->save() )
            return false;

        if ( $req->has('languages') )
            if ( !$this->updateTransliterations($req) )
                return false;

        if ( $req->has('point') )
            $this->storePoint($req->point['lat'], $req->point['lng']);

        if ( $req->has('admins') && $req['admins']!=='' ) {
            $this->admin()->sync( $req->admins );
        }

        if ( $req->hasFile('logo') ) {
            $this->storeLogo($req->logo);
        }

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        if ( $req->hasFile('video') )
            $this->storeVideo($req->video);



        return true;

    }

    public function patchInitialize() {
        parent::patchInitialize();

        $this->rate = $this->approvedRates()->avg('rate');
        $this->rate_count=\DB::table('rates')->where('object_id','=',$this->id)->where('status','=','approved')->where('object_type','=','3')->wherenotNull('rate')->count();
//        $this->rate_count = $this->approvedRates()->count();
        return $this;
    }

    public function postCreation($req = null) {
        $this->makeGallery();

        if ( $req->hasFile('logo') ) {
            $this->storeLogo($req->logo);
        }

        if ( $req->has('point') )
            $this->storePoint($req->point['lat'], $req->point['lng']);

        if ( $req->has('admins') ) {
            $this->admin()->sync( $req->admins );
        }

        if ( $req->hasFile('cover') )
        $this->storeCover($req->cover);

        if ( $req->hasFile('video') )
        $this->storeVideo($req->video);


        if ( $req->has('gallery') )
        foreach ($req->gallery as $file)
        $this->addImageToGallery($file);


        return true;
    }

    public function delete() {
        return parent::delete()
            && $this->deleteLogoImage()
            && $this->deleteVideo()
            && $this->deleteGallery();
    }



    //      -- Accessors --

    public function getFlagAttribute() {
        return 3;
    }



    public function getCoverImageAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'winery', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getLogoImageAttribute() {
        return ( $this->hasLogoImage() ) ? route('logo_image', ['object' => 'winery', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getVideoAttribute() {
        return  ( $this->hasVideo() ) ? url('winery/video/' . $this->id) : null;
    }


    // public function getGalleryAttribute() {
    //     $files = collect( Storage::disk( $this->storageDisk )->files( $this->galleryDiskPath() ) );
    //     $id = $this->id;
    //     return $files->map(function ($f) use ($id) {
    //         $f = pathinfo($f)['basename'];
    //         return route('gallery_image', ['wineryId' => $id, 'image' => $f]);
    //     })->values();
    // }



    //      -- Mutators --

    public function setMondayAttribute($value) {
        $this->attributes['monday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                                 : '/';
    }

    public function setTuesdayAttribute($value) {
        $this->attributes['tuesday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                                 : '/';
    }

    public function setWednesdayAttribute($value) {
        $this->attributes['wednesday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                                 : '/';
    }

    public function setThursdayAttribute($value) {
        $this->attributes['thursday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                : '/';
    }

    public function setFridayAttribute($value) {
        $this->attributes['friday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                : '/';
    }

    public function setSaturdayAttribute($value) {
        $this->attributes['saturday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                : '/';
    }

    public function setSundayAttribute($value) {
        $this->attributes['sunday'] =
            ( is_array($value) ) ? implode($value, ' - ')
                : '/';
    }



    //      -- Custom methods --


        // Logo image

    public function hasLogoImage() {
        return Storage::disk('wineries')->exists( $this->logoDiskPath() );
    }

    public function logoDiskPath() {
        return 'logos/' . $this->id;// . '.jpg';
    }

    public function logoFullPath() {
        return Storage::disk('wineries')->path( $this->logoDiskPath() );
    }

    public function storeLogo($image) {
        // try {
        //     $image = Image::make($image);
        //     $image->resize(120, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //     });
        // } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
        //     return false;
        // }
        if($image==null)
            return $this->deleteLogoImage();

        return $image->storeAs( '', $this->logoDiskPath(), $this->storageDisk );
        return $image->save( $this->logoFullPath() );
    }

    public function deleteLogoImage() {
        return ( $this->hasLogoImage() ) ? Storage::disk( $this->storageDisk )->delete( $this->logoDiskPath() ) : true;
    }


        // Cover video

    public function hasVideo() {
        return Storage::disk('wineries')->exists( $this->videoDiskPath() );
    }

    public function videoDiskPath() {
        return 'videos/' . $this->id . '.mp4';
    }

    public function videoFullPath() {
        return Storage::disk('wineries')->path( $this->videoDiskPath() );
    }

    public function storeVideo($video) {
        if($video==null)
            return $this->deleteVideo();
            
        return $video->storeAs( '', $this->videoDiskPath(), $this->storageDisk );
    }

    public function deleteVideo() {
        return ( $this->hasVideo() ) ? Storage::disk( $this->storeDisk )->delete( $this->videoDiskPath() ) : true;
    }


        // Gallery

    public function galleryPath($addition = null) {
        return Storage::disk( $this->storageDisk )->path( $this->galleryDiskPath($addition) );
    }

    private function galleryDiskPath($addition = null) {
        $path = 'galleries/' . $this->id;
        return ( is_null($addition) ) ? $path : $path . '/' . $addition;
    }

    public function searchGalleryByName($name) {
        $files = glob( $this->galleryPath($name) . '.*' );
        foreach ($files as $index => $file) {
            $file = basename($file);
            if ($file == '.' || $file == '..') {
                unset($files[$index]);
                continue;
            }
            $files[$index] = $file;
        }
        return $files;
    }

    public function galleryHas($image) {
        return count( $this->searchGalleryByName($image) ) > 0;
    }

    public function galleryImage($imageId) {
        $image = $this->gallery()->where('id', $imageId)->first();
        if ( !$image )
            return false;

        return $image->fullPath;
    }

    public function addImageToGallery($image) {
       $file = new \App\File;
       $file->position = $this->fileAvailablePosition();
       $file->winery_id = $this->id;
       $file->storeFile($image);
    }

    public function fileAvailablePosition() {
        return $this->gallery()->count() + 1;
    }

    public function removeFileFromGallery($id) {
        $file = $this->gallery()->where('id', $id)->first();
        return ( !is_null($file) ) ? $file->delete() : true;
    }

    public function makeGallery() {
        return Storage::disk( $this->storageDisk )->makeDirectory( $this->galleryDiskPath() );
    }

    public function deleteGallery() {
        return Storage::disk( $this->storageDisk )->deleteDirectory( $this->galleryDiskPath() );
    }






    public static function filterByDistance($langId, $lat, $long, $getQuery = false) {
        $q = static::list($langId, 'asc', true);

        $q->leftJoin('pins', function ($q) {
            $q->on( 'pins.object_id', '=', 'wineries.id' );
            $q->where( 'pins.object_type', (new static)->flag );
        });

        $distanceCalculation = "( 111.111 * DEGREES(ACOS(COS(RADIANS(pins.lat))
                          * COS(RADIANS({$lat}))
                          * COS(RADIANS(pins.lng - {$long}))
                          + SIN(RADIANS(pins.lat))
                          * SIN(RADIANS({$lat})))) )";

        $q->addSelect( app('db')->raw($distanceCalculation . ' as distance') );

        return ($getQuery) ? $q : $q->get();

    }
    public function loadAllWineries($languageId=1)
    {
        $winaries=static::list($languageId,'asc',true,'')->get();
        foreach ($winaries as $winery)
        {
            $winery->pin=$winery->pin;
            $winery->makeHidden(['rate','area','flag','cover_image','logo_image','video','recommended','rate_count','highlighted','uto','sre','cet','pet']);
        }
        return $winaries;
    }
    public function getWorkingTimeAttribute()
    {
        return [
            'monday'=> $this->monday,
            'tuesday'=> $this->tuesday,
            'wednesday'=> $this->wednesday,
            'thursday'=> $this->thursday,
            'friday'=> $this->friday,
            'saturday'=> $this->saturday,
            'sunday'=> $this->sunday
        ];
    }
    public function getRateAttribute()
    {
        $rate= $this->approvedRates()->whereNotNull('rate');
        if($rate->count()>0)
            return floatval($rate->sum('rate')/$rate->count());
        else return 0;
    }
    public function getRateCountAttribute()
    {
        $rates= $this->approvedRates()->whereNotNull('rate');
        if($rates->count()>0)
            return floatval($rates->count());
        else return 0;
    }




}
