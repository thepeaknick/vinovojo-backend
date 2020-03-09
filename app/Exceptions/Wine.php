<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManagerStatic as Image;

class Wine extends BaseModel {

    protected $fillable = [
        'id', 'name', 'description', 'harvest_year', 'serving_temp', 'alcohol', 'serbia_bottles', 'type', 'recommended', 'category_id', 'winery_id', 'area_id', 'background', 'classification_id', 'highlighted', 'wine_type'
    ];

    protected $hidden = [
        'winery_id', 'transliterations', 'category_id'
    ];

    protected static $listData = [
    	'wines.id as id', 'wineTransliteration.value as name', 'harvest_year', 'wines.recommended as recommended', 'wineryTransliteration.value as winery_name', 'wines.background as background', 'wines.highlighted as highlighted'
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
        return $this->hasMany('App\Rate', 'object_id')->where('object_type', $this->flag)->latest('created_at');
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



    //      -- CRUD override --

    public static function list($lang, $sorting = 'asc', $getQuery = false) {
        // select everything needed including rates
        $q = static::select( static::$listData );
        $q->addSelect( app('db')->raw( 'avg(rates.rate) as rate, count(rates.id) as rate_count' ) );

        // join rates to the query
        $q->leftJoin('rates', function ($q) {
            $q->on('wines.id', '=', 'rates.object_id');
            $q->where('rates.object_type', (new static)->flag );
            $q->where('status', 'approved');
        });

        // join wineries
        $q->leftJoin('wineries', 'wines.winery_id', '=', 'wineries.id');

        // join the transliteration table in order to load wine name
        $q->join('text_fields as wineTransliteration', function ($q) use ($lang) {
            $q->on('wines.id', '=', 'wineTransliteration.object_id');
            $q->where('wineTransliteration.object_type', (new Wine)->flag);
            $q->where('wineTransliteration.name', 'name');
            $q->where('wineTransliteration.language_id', $lang);
        });

        // join the transliteration table in order to load winery name
        $q->leftJoin('text_fields as wineryTransliteration', function ($q) use ($lang) {
            $q->on('wineries.id', '=', 'wineryTransliteration.object_id');
            $q->where('wineryTransliteration.object_type', (new \App\Winery)->flag);
            $q->where('wineryTransliteration.name', 'name');
            $q->where('wineryTransliteration.language_id', $lang);
        });

        // group by wines
        $q->groupBy('wines.id');

        $q->orderBy('wines.highlighted', 'desc');
        $q->orderBy( static::$listSort, $sorting );

        // if $getQuery flag is true return the query instance, else return query results
        return ($getQuery) ? $q : $q->paginate(10); // it werks
    }

    public function singleDisplay($languageId = null) {
        $this->desiredLanguage = $languageId;
        $this->load( $this->relationships );

        $this->classes->transliterate($languageId);

        $this->load( ['approvedRates' => function ($q) { $q->limit(3); }, 'approvedRates.user', 'winery.area'] );

        $this->rate_count = $this->approvedRates()->count();
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
        $this->rate_count = $this->approvedRates()->count();

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
        return ( $this->hasBottleImage() ) ? route('bottle_image', ['id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 2;
    }

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
