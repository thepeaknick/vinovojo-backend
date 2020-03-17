<?php

namespace App;

use DB;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManagerStatic as Image;

class Wine extends BaseModel {

    // public $attributes= ['areas_nested'=>''];
    protected $fillable = [
        'id', 'name', 'description', 'harvest_year', 'serving_temp', 'alcohol', 'serbia_bottles', 'type', 'recommended', 'category_id', 'winery_id', 'area_id', 'background', 'classification_id', 'highlighted', 'wine_type'
    ];

    protected $hidden = [
        'winery_id', 'transliterations'
    ];

    protected static $listData = [
    	'wines.id as id', 'wineTransliteration.value as name', 'harvest_year','wines.category_id as category_id', 'wines.recommended as recommended', 'wines.area_id as area_id', 'wineryTransliteration.value as winery_name', 'wines.background as background', 'wines.highlighted as highlighted'
    ];

    public static $transliteratesLists = true;

    protected $appends = [
        'cover_image', 'bottle_image', 'flag'
    ];

    protected $storageDisk = 'wines';

    public $rules = [
        'harvest_year' => 'numeric|required',
        'serving_temp' => 'numeric|required',
        'alcohol' => 'numeric|required',
        'serbia_bottles' => 'numeric|required',
        'type' => 'string|required',
        'category_id' => 'numeric|exists:wine_categories|required',
        'winery_id' => 'numeric|exists:wineries|required'
    ];

    protected $relationships = [
        'availableLanguages', 'category', 'area', 'classes', 'classification', 'winetypes'
    ];

    protected static $flag= 3;



    //      -- Relationships --

    public function winetypes() {
        return $this->belongsTo('\App\WineType', 'wine_type');
    }

    public function classes() {
        return $this->belongsToMany('App\WineClass', 'classes_wines', 'wine_id', 'class_id');
    }

    public function comments() {
        return $this->hasMany('App\Rate', 'object_id')->where('object_type', $this->flag)->where('status', 'approved')->latest();
    }

    public function rates() {
        return $this->hasMany('App\Rate', 'object_id')->where('object_type', $this->flag)->orderBy('status','asc')->latest();
    }

    public function approvedRates() {
        return $this->rates()->where('status', 'approved');
    }

    public function winery() {
        $lang = $this->desiredLanguage;
        return $this->belongsTo('App\Winery')
                ->leftJoin( (new \App\TextField)->getTable() . ' as wineryTransliteration', function ($query) use ($lang) {
                    $query->on('wineryTransliteration.object_id', '=', 'wineries.id');
                    $query->where('wineryTransliteration.object_type', (new \App\Winery)->flag );
                    $query->where('wineryTransliteration.name', 'name');
                    $query->where('wineryTransliteration.language_id', $lang);
                })
                ->select('wineries.id as id', 'wineryTransliteration.value as name', 'wineries.area_id as area_id');
    }

    public function category() {
        $lang = $this->desiredLanguage;
        return $this->belongsTo('App\Category')
                ->select('wine_categories.id as id', 'transliteration.value as name')
                ->leftJoin('text_fields as transliteration', function ($q) use ($lang) {
                    $q->on('wine_categories.id', '=', 'transliteration.object_id');
                    $q->where('transliteration.object_type', (new Category)->flag);
                    $q->where('transliteration.name', 'name');
                    $q->where('transliteration.language_id', $lang);
                });
    }

    public function area() {
        $languageId = app('translator')->getLocale();
//        $area= \App\Winery::where('object_id','=',$this->id)
//                            ->where('');
        return $this->belongsTo('App\Area')->select('areas.id as id', 'transliteration.value as name', 'areas.type as type', 'areas.parent_id as area_parent_id')
                                           ->join('text_fields as transliteration', function ($q) use ($languageId){
                                                $q->on('areas.id', '=', 'transliteration.object_id');
                                                $q->where('object_type', (new \App\Area)->flag);
                                                $q->where('transliteration.name', 'name');
                                                if ($languageId) {
                                                    $q->where('language_id', $languageId);
                                                }
                                           });
    }

    public function classification() {
        return $this->belongsTo('App\WineClassification', 'classification_id');
    }


    public static function listWithLiked($language,$sorting= 'asc', $getQuery=false, $search='',$orderBy='') {
        if(app('auth')->user()!==NULL) {
            $data=static::list($language,$sorting,true,$search,$orderBy)->get();
            // dd($data);
            $allData=collect();
            foreach($data as $wine) {
                $marketing=new \App\Highlight();
                $marketing->checkAndModify($wine->id,(new static)->flag);
                $exists=\App\Favourite::where('object_id','=',$wine->id)->where('favourites.object_type', '=', '3')->first();
                // dd($data[0]);
                if($exists!==NULL){
                    // array_merge($data[$i],['liked'=>1]);
                    // $data[$i]->merge(['liked'=>1]);
                    $wine->push('liked',1);
                    $wine->liked=1;
                    $wine['liked']=1;
                }

                else {
                    $wine->push('liked',0);
                    $wine->liked=0;
                    $wine['liked']=0;
                }
                $allData->push($wine->toArray());
            }
            // dd($data);
            return ($getQuery)?$allData:$allData->paginate(10);
        }
        else return static::list($language,$sorting,$getQuery,$search,$orderBy);
//        dd('sdgs');
    }

    public static function listByWineryDistance(Request $req, $langId)
    {
        $shouldSortByLocation= true;
        $q= $q = static::select( static::$listData );
        
        $q->join('wineries','wineries.id','=','wines.winery_id');
        $q->addSelect('wineries.id as winery_id');

        // $q->with('areas');
        
        if($req->has('lng') && $req->has('lat')) {
            // join pins
            $q->join('pins', function($join) {
                $join->on('wineries.id','=','pins.object_id');
                $join->where('pins.object_type','=',(new Winery)->flag);
            });
    
            $lng= $req->lng;
            $lat= $req->lat;
            // distance calculation
            $distanceCalculation = "( 111.111 * DEGREES(ACOS(COS(RADIANS(pins.lat))
                                        * COS(RADIANS({$lat}))
                                        * COS(RADIANS(pins.lng - {$lng}))
                                        + SIN(RADIANS(pins.lat))
                                        * SIN(RADIANS({$lat})))) ) as winery_distance";
            $q->addSelect(app('db')->raw($distanceCalculation));
        }else {
            $q->join('pins', function($join) {
                $join->on('wineries.id','=','pins.object_id');
                $join->where('pins.object_type','=',(new Winery)->flag);
            });
            $shouldSortByLocation= false;
        }

        // translates
        $q->leftJoin('text_fields as wineTransliteration', function($join) use($langId,$req) {
            $join->on('wineTransliteration.object_id','=','wines.id');
            $join->where('wineTransliteration.object_type','=',(new Wine)->flag);
            $join->where('wineTransliteration.name','name');
            $join->where('wineTransliteration.language_id','=',$langId);
        });
        
        $q->leftJoin('text_fields as wineryTransliteration', function ($q) use ($langId) {
            $q->on('wineries.id', '=', 'wineryTransliteration.object_id');
            $q->where('wineryTransliteration.object_type', (new \App\Winery)->flag);
            $q->where('wineryTransliteration.name', 'name');
            $q->where('wineryTransliteration.language_id', $langId);
        });

        // load rates
        $q->leftJoin('rates', function($join)use ($req) {
            $join->on('rates.object_id','=', 'wines.id');
            $join->where('rates.object_type','=', (new Wine)->flag);
            $join->where('rates.status','=','approved');
        });
        $q->addSelect( app('db')->raw( "avg(rates.rate) as rate,count(rates.rate) as rate_count" ) );

        // // load areas and parent and parent
        // $q->join('areas', function ($q)use($langId) {
        //     $q->on('wineries.area_id','=', 'areas.id');
        //     // join translates
        //     $q->join('text_fields as areaTransliteration', function($q) use ($langId) {
        //         $q->on('areas.id', '=', 'areaTransliteration.object_id');
        //         $q->where('areaTransliteration.object_type', (new Area)->flag);
        //         $q->where('areaTransliteration.name', 'name');
        //         if ($langId) {
        //             $q->where('language_id', $langId);
        //         }
        //     });
        //     $q->join('areas as parent', function($q)use ($langId) {
        //         $q->on('areas.parent_id', '=', 'parent.id');
        //         $q->join('text_fields as parentAreaTransliteration', function($q) use ($langId) {
        //             $q->on('parent.id', '=', 'parentAreaTransliteration.object_id');
        //             $q->where('parentAreaTransliteration.object_type', (new Area)->flag);
        //             $q->where('parentAreaTransliteration.name', 'name');
        //             if ($langId) {
        //                 $q->where('language_id', $langId);
        //             }
        //         });
        //     });
        //     return $q;
        // });
        // $q->addSelect(['areas.id as id, areaTransliteration.value as area_name, parentAreaTransliteration.value as parent_name']);
        // print_r($q->toSql());die();
        // filters
        if($req->has('area_id') && !empty($req->area_id) && ctype_digit($req->area_id)) {
            $area_ids=[];
            $area_id= $req->area_id;
            $query="SELECT a.id as a_id, p_a.id as p_id, pp_a.id as pp_id FROM areas a INNER JOIN areas p_a ON a.parent_id=p_a.id INNER JOIN areas pp_a ON p_a.parent_id= pp_a.id WHERE a.id= $area_id OR p_a.id= $area_id OR pp_a.id= $area_id";
            $areas= DB::select(DB::raw($query));
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wines.area_id', array_unique($area_ids));
        }
        
        if($req->has('category_id')) 
            $q->where('category_id',$req->category_id);

        if($req->has('class_id')) {
            $q->join('classes_wines as classes', function($join)use ($req) {
                $join->on('wines.id','=','classes.wine_id');
                $join->where('classes.class_id','=',$req->class_id);
            });
        }

        if($req->has('harvest_year')) 
            $q->where('harvest_year','=',$req->harvest_year);

        if($req->has('winery_id')) {
            $shouldSortByLocation=false;
            $q->where('winery_id','=', $req->winery_id);
        }

        if($req->has('alcohol')) 
            $q->where('alcohol','=', $req->alcohol);

        if($req->has('min_rate')) {
            $join->having('rates', '>', $req->min_rate);
        }

        // order
        if(!empty($req->header('SortBy')))
        {
            $SortBy= $req->header('SortBy');
            $sortingType= ($req->header('Sorting')=='1')?'asc':'desc';
            $isSortByRate= $SortBy==='rate';
            // dd($isSortByRate);
            if($isSortByRate) {
                $q->orderBy('rate', $sortingType);
            }

            $q->orderBy('highlighted', 'desc');
            $q->orderBy('recommended', 'desc');
            
            if($shouldSortByLocation && !$isSortByRate) {
                $q->orderBy('winery_distance', 'asc');
            }
        }else {
            if($shouldSortByLocation) {
                $q->orderBy('winery_distance', 'asc');
                $q->orderBy('highlighted', 'desc');
                $q->orderBy('recommended', 'desc');
            }else {
                $q->orderBy('highlighted', 'desc');
                $q->orderBy('recommended', 'desc');
            }
            
        }

        $q->groupBy('wines.id');
        $q->with(['classes','area','area.parent']);


        // handle search
        if($req->has('search'))
            $q->where('wineTransliteration.value','like','%'.$req->search.'%');

        $q->addSelect('pins.lat as lat');
        $q->addSelect('pins.lng as lng');


        return $q;
    }

    public function listMobile(Request $r, $lang)
    {
        $q= $q = static::select( static::$listData );
        
        $q->join('wineries','wineries.id','=','wines.winery_id');
        
        // join pins
        $q->join('pins', function($join) {
            $join->on('wineries.id','=','pins.object_id');
            $join->where('pins.object_type','=',(new Winery)->flag);
        });

        // translates
        $q->leftJoin('text_fields as wineTransliteration', function($join) use($langId,$req) {
            $join->on('wineTransliteration.object_id','=','wines.id');
            $join->where('wineTransliteration.object_type','=',(new Wine)->flag);
            $join->where('wineTransliteration.name','name');
            $join->where('wineTransliteration.language_id','=',$langId);
        });
        
        $q->leftJoin('text_fields as wineryTransliteration', function ($q) use ($langId) {
            $q->on('wineries.id', '=', 'wineryTransliteration.object_id');
            $q->where('wineryTransliteration.object_type', (new \App\Winery)->flag);
            $q->where('wineryTransliteration.name', 'name');
            $q->where('wineryTransliteration.language_id', $langId);
        });

        $q->orderBy('winery_distance','asc');
        $q->addSelect('pins.lat as lat');
        $q->addSelect('pins.lng as lng');

    }



    //      -- CRUD override --

    public static function list($lang, $sorting = 'asc', $getQuery = false,$search='',$orderBy='') {
        // select everything needed including rates
        $q = static::select( static::$listData );
        $q->addSelect( app('db')->raw( "avg(rates.rate) as rate,count(rates.rate) as rate_count" ) );

        // join rates to the query
        $q->leftJoin('rates', function ($q)use($sorting) {
            $q->on('wines.id', '=', 'rates.object_id');
            $q->where('rates.object_type', (new static)->flag );
            $q->where('status', 'approved');
            // $q->orderBy('rates.rate', $sorting);
        });
        // join wineries
        $q->leftJoin('wineries', 'wines.winery_id', '=', 'wineries.id');

        // add pins lng and lat
        $q->join('pins', function($join) {
            $join->on('wineries.id','=','pins.object_id');
            $join->where('pins.object_type','=',(new Winery)->flag);
        });
        $q->addSelect('pins.lat as lat');
        $q->addSelect('pins.lng as lng');

        $q->with('classes');
        // join the transliteration table in order to load wine name
        $q->leftJoin('text_fields as wineTransliteration', function ($q) use ($lang,$search) {
            $q->on('wines.id', '=', 'wineTransliteration.object_id');
            $q->where('wineTransliteration.object_type', (new Wine)->flag);
            $q->where('wineTransliteration.name', 'name');
//            $q->where('wineTransliteration.value','like',"%$search%");
            if($search!=='')
                $q->where('wineTransliteration.value','like','%'.rtrim($search.'%',' ').'%');
            $q->where('wineTransliteration.language_id', $lang);
        });

        $q->addSelect(app('db')->raw('wines.area_id as area_id','wineTransliteration.value as winery_name', 'wines.winery_id as wineryid'));

        // handle filters
        $req= app('request');

        if($req->has('winery_id'))
            $q->where('winery_id',$req->winery_id);

        if($_SERVER['REQUEST_URI']==='/get/wine' && $req->has('class_id')) {
            $q->where('wines.category_id','=',$req->class_id);
        }


        // join the transliteration table in order to load winery name
        $q->leftJoin('text_fields as wineryTransliteration', function ($q) use ($lang) {
            $q->on('wineries.id', '=', 'wineryTransliteration.object_id');
            $q->where('wineryTransliteration.object_type', (new \App\Winery)->flag);
            $q->where('wineryTransliteration.name', 'name');
            $q->where('wineryTransliteration.language_id', $lang);
        });
        /**
         *  WIne list problem
         */
        // $q->join('pins', function($q) {
        //     $q->on('pins.object_id','=','wineries.id');
        //     $q->where('pins.object_type','=',(new Winery)->flag);
        // });
        // $q->addSelect('pins.lat as lat');
        // $q->addSelect('pins.lng as lng');

        if($req->has('search'))
            $q->where('wineTransliteration.value','like','%'.$req->search.'%');

        // if($search!=='')
        //     $q->where('wineTransliteration.value','like','%'.$search.'%');


        if($req->has('category_id') && !empty($req->category_id))
            $q->where('wines.category_id','=',$req->category_id);

        if ( $req->has('area_id')&& !empty($req->area_id) && ctype_digit($req->area_id) )
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
            $areas=\DB::select(\DB::raw($query));
            foreach ($areas as $area) {
                if(is_int($area->a_id))
                    $area_ids[]= $area->a_id;
                if(is_int($area->p_id))
                    $area_ids[]= $area->p_id;
                if(is_int($area->pp_id))
                    $area_ids[]= $area->pp_id;
            }
            $q->whereIn('wines.area_id', array_unique($area_ids));
        }
        // group by wines
        $q->groupBy('wines.id');

        // dd($req->SortBy);
        if(!empty($req->header('SortBy')) && $req->header('SortBy')!=='asc')
        {
            $sort= $req->header('Sorting','asc');
            $q->orderBy($req->header('SortBy'), $sort);
        }
        // print_r($q->toSql());die();
        // if($orderBy!==''){
        //     $q->orderBy($orderBy,$sorting);
        // }

//         dd($q->toSql());
        // if($req->has('sort'))
        // {
        //     // 1 rastuce 0 opadajuce
        //     if($req->sort==0) {
        //         $q->orderBy('rates.status','asc');
        //         $q->orderBy('rates.rate', 'asc');
        //     }
        //     if($req->sort==1) {
        //         $q->orderBy('rates.status', 'asc');
        //         $q->orderBy('rates.rate', 'desc');
        //     }
        // }
        // dd($sorting);
        if($sorting=='asc') 
            $q->orderBy('rates.rate',$sorting);
        else
            $q->orderBy('rates.rate','desc');

        // $q->orderBy( static::$listSort, $sorting );
        
        if($getQuery)
            return $q;
        else {
            foreach ($q->get() as $instance) {
                        $marketing=new \App\Highlight();
                        $marketing->checkAndModify($instance->id,(new static)->flag);
                if(isset($instance->search_count))  {
                    $instance->search_count=$instance->approvedRates()->whereNotNull('rate')->groupBy('id')->get()->count();
                    //var_dump($instance->search_count);

                }
            }
//            die();
        }
        // if $getQuery flag is true return the query instance, else return query results
        return ($getQuery) ? $q : $q->paginate(10); // it werks
    }

    public function singleDisplay($languageId = null) {
        $this->desiredLanguage = $languageId;
        $this->load( $this->relationships );

        $this->classes->transliterate($languageId);
        $this->winetypes->transliterate($languageId);
        $this->load( ['approvedRates' => function ($q) { $q->limit(3); }, 'approvedRates.user', 'winery.area'] );
//        $this->setAppends(['classification']);

        $this->rate_count=$this->approvedRates()->whereNotNull('rate')->groupBy('id')->get()->count();
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
        $this->rate = $this->approvedRates()->avg('rate');

        if (Auth::user())
            $this->user_rates = $this->rates()->where('user_id', Auth::user()->id)->where('status', 'hold')->get();

        $search = app('request')->header('Pragma');
        if ( !is_null($search) && $search == 'search' )
            $this->incrementSearch();

        return $this;
    }

    public function update($req = [], $options = []) {
        if ( !parent::update($req) )
            return false;

        if ( $req->has('classes') )
            $this->classes()->sync( collect($req->classes)->pluck('id') );

        if ( $req->has('bottle') )
            $this->storeBottle( $req->bottle );

        return true;
    }

    public function postCreation($req = null) {
        if ( $req->has('classes') )
            $this->classes()->sync($req->classes);

        if ( $req->hasFile('logo') ) {
            $this->storeLogo($req->logo);
        }

        if ( $req->hasFile('bottle') )
            $this->storeBottle($req->bottle);

        return true;
    }

    public function patchInitialize() {
        parent::patchInitialize();

        $this->rate = $this->approvedRates()->avg('rate');
        $this->rate_count=\DB::table('rates')->where('object_id','=',$this->id)->where('object_type','=','2')->where('status','=','approved')->where('rates.rate','!=','null')->count();
        return $this;
    }

    public function delete() {
        return parent::delete()
            && $this->deleteBottleImage();
    }



    //      -- Accessors --

    public function getCoverImageAttribute() {
        return ( is_null($this->winery) ) ? null : $this->winery->cover_image;
    }

    public function getBottleImageAttribute() {
        // return ( $this->hasBottleImage() ) ? route('bottle_image', ['id' => $this->id, 'antiCache' => time()]) : null;
        // dd($_SERVER['SERVER_NAME']);
        return ( $this->hasBottleImage() ) ? url('/bottle/'.$this->id.'/'.time()) : null;
    }

    public function getFlagAttribute() {
        return 2;
    }

//    public function getAreasNestedAttribute() {
//        return $this->attributes['areas_nested'];
//    }
//    public function setAreasNestedAttribute($value) {
//        $this->attributes['areas_nested']= $value;
//    }

    public function loadWineryId()
    {
        return $this->winery;
    }

    // public function getAreasNestedAttribute()
    // {
    //     return $this->areas_nested;
    // }

    // public function setAreasNestedAttribute($value)
    // {
    //     $this->areas_nested= $value;
    // }


    // public function getRateAttribute() {
    //     return (float) $this->rates()->where('rate', 1)->avg('rate');
    // }



    //      -- Custom methods --

    public function hasBottleImage() {
        return Storage::disk( $this->storageDisk )->exists( $this->bottleDiskPath() );
    }

    public function bottleDiskPath() {
        return 'bottles/' . $this->id;// . '.png';
    }

    public function bottleFullPath() {
        return Storage::disk('wines')->path( $this->bottleDiskPath() );
    }

    public function storeBottle($image) {
        try {
            $image = Image::make($image);
            $image->resize(null, 340, function ($constraint) {
                $constraint->aspectRatio();
            });
        } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
            return false;
        }
        return $image->save( $this->bottleFullPath() );
    }

    public function deleteBottleImage() {
        return Storage::disk( $this->storageDisk )->delete( $this->bottleDiskPath() );
    }


}
