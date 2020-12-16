<?php

namespace App;

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
            $allData=collect();
            foreach($data as $wine) {
                $marketing=new \App\Highlight();
                $marketing->checkAndModify($wine->id,(new static)->flag);
                $exists=\App\Favourite::where('object_id','=',$wine->id)->where('favourites.object_type', '=', '3')->first();
                if($exists!==NULL){
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
            return ($getQuery)?$allData:$allData->paginate(10);
        }
        else return static::list($language,$sorting,$getQuery,$search,$orderBy);
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
            $q->orderBy('rates.rate', $sorting);
        });
        // join wineries
        $q->leftJoin('wineries', 'wines.winery_id', '=', 'wineries.id');
        $q->with('classes');
        // join the transliteration table in order to load wine name
        $q->leftJoin('text_fields as wineTransliteration', function ($q) use ($lang,$search) {
            $q->on('wines.id', '=', 'wineTransliteration.object_id');
            $q->where('wineTransliteration.object_type', (new Wine)->flag);
            $q->where('wineTransliteration.name', 'name');
            if($search!=='')
                $q->where('wineTransliteration.value','like','%'.rtrim($search.'%',' ').'%');
            $q->where('wineTransliteration.language_id', $lang);
        });

        $q->addSelect(app('db')->raw('wines.area_id as area_id','wineTransliteration.value as winery_name', 'wines.winery_id as wineryid'));

        // handle filters
        $req= app('request');

        if($req->has('winery_id'))
            $q->where('winery_id',$req->winery_id);

        // Needed from Web api / different route and params than mobile api
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

        if($req->has('search'))
            $q->where('wineTransliteration.value','like','%'.$req->search.'%');


        if($req->has('category_id') && !empty($req->category_id))
            $q->where('wines.category_id','=',$req->category_id);

        // Nested areas
        if ( $req->has('area_id')&& !empty($req->area_id) && ctype_digit($req->area_id) )
        {
            $area_ids=[];
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

        if(!empty($req->header('SortBy')))
        {
            $sort= $req->header('Sorting','asc');
            $q->orderBy($req->header('SortBy'), $sort);
        }

        if($sorting=='asc') 
            $q->orderBy('rates.rate',$sorting);
        else
            $q->orderBy('rates.rate','desc');
        
        if($getQuery)
            return $q;
        else {
            foreach ($q->get() as $instance) {
                        $marketing=new \App\Highlight();
                        $marketing->checkAndModify($instance->id,(new static)->flag);
                if(isset($instance->search_count))  {
                    $instance->search_count=$instance->approvedRates()->whereNotNull('rate')->groupBy('id')->get()->count();
                }
            }
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

        $this->rate_count=$this->approvedRates()->whereNotNull('rate')->groupBy('id')->get()->count();
        $areas= \App\Area::with('parent')->where('areas.id','=',$this->area_id)
                    ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($languageId) {
                        $query->select('transliteration.name as name');
                        $query->on('transliteration.object_id', '=', (new \App\Area)->getTable() . '.id');
                        $query->where('transliteration.object_type', (new \App\Area)->flag);
                        $query->where('transliteration.name', 'name');
                        $query->where('transliteration.language_id', $languageId);
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
        // dd($app->url)
        return ( $this->hasBottleImage() ) ? url('/bottle/'.$this->id.'/'.time()) : null;
    }

    // Flag in relations
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

    //      -- Custom methods --

    public function hasBottleImage() {
        return Storage::disk( $this->storageDisk )->exists( $this->bottleDiskPath() );
    }

    public function bottleDiskPath() {
        return 'bottles/' . $this->id;// . '.png';
    }

    public function bottleFullPath() {
        return Storage::disk('wines')->url( $this->bottleDiskPath() );
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
