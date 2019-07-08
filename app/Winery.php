<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManagerStatic as Image;

class Winery extends BaseModel {

    protected $fillable = [
        'address', 'recommended', 'background', 'webpage', 'ponpet', 'sub', 'ned', 'area_id', 'contact_person', 'contact', 'name', 'description', 'highlighted', 'admin_id'
    ];

    protected $hidden = [
        'area_id', 'transliterations', 'rates'
    ];

    protected static $listData = [
        'wineries.id as id', 'wineries.address as address', 'recommended', 'transliteration.value as name', 'wineries.highlighted as highlighted'
    ];

    protected $appends = [
        'flag', 'cover_image', 'logo_image', 'video'
    ];

    protected $storageDisk = 'wineries';

    protected $relationships = [
        'rates', 'categories', 'area', 'availableLanguages', 'pin', 'gallery', 'admin'
    ];

    public $rules = [
        'address' => 'string|required',
        'ponpet' => 'present',
        'sub' => 'present',
        'ned' => 'present',
        'area_id' => 'numeric',
        'languages' => 'array|min:1|required'
    ];



    //      -- Relationships --
    
    public function gallery() {
        return $this->hasMany('App\File')->orderBy('position', 'asc');
    }

    public function rates() {
        return $this->hasMany('App\Rate', 'object_id')->where('object_type', $this->flag)->latest('created_at');
    }

    public function approvedRates() {
        return $this->rates()->where('status', 'approved');
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
        return $this->belongsTo('App\Area')->select('areas.id as id', 'transliteration.value as name', 'areas.type as type', 'areas.parent_id as area_parent_id')
                                           ->join('text_fields as transliteration', function ($q) use ($languageId) {
                                                $q->on('areas.id', '=', 'transliteration.object_id');
                                                $q->where('object_type', (new \App\Area)->flag);
                                                $q->where('transliteration.name', 'name');
                                                if ($languageId) {
                                                    $q->where('language_id', $languageId);
                                                }
                                           });
    }

    public function pin() {
        return $this->hasOne('App\Pin', 'object_id')->where('object_type', $this->flag);
    }

    public function admin() {
        return $this->belongsToMany('App\User');
    }



    //      -- CRUD override -- 

    public static function list($lang, $sorting = 'asc', $getQuery = false) {
        $q = static::select( static::$listData );

        $q->addSelect( app('db')->raw( 'avg(rates.rate) as rate, count(rates.id) as rate_count' ) );
        // $q->addSelect('areaTransliteration.value as area');
        $q->addSelect('wineries.area_id as area_id');

        $q->with('area.parent');

        $q->leftJoin('rates', function ($q) {
            $q->on('wineries.id', '=', 'rates.object_id');
            $q->where('rates.object_type', (new static)->flag );
            $q->where('status', 'approved');
        });

        $q->join('text_fields as transliteration', function ($q) use ($lang) {
            $q->on('wineries.id', '=', 'transliteration.object_id');
            $q->where('transliteration.object_type', (new static)->flag);
            $q->where('name', 'name');
            $q->where('transliteration.language_id', $lang);
        });

        // $q->join('areas', 'areas.id', '=', 'wineries.area_id');
        // $q->join('text_fields as areaTransliteration', function($q) use($lang) {
        //     $q->on('areaTransliteration.object_id', '=', 'areas.id');
        //     $q->where('areaTransliteration.object_type', (new Area)->flag);
        //     $q->where('areaTransliteration.name', 'name');
        //     $q->where('areaTransliteration.language_id', $lang);
        // });

        $sortBy = app('request')->header('Sort-By', static::$listSort);

        $q->orderBy( $sortBy, $sorting );

        $q->groupBy('wineries.id');
        $q->orderBy('wineries.highlighted', 'desc');

        if ($getQuery)
            return $q;
        
        $data = $q->paginate(10);
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
        
        $this->rate_count = $this->approvedRates()->count();
        $this->rate = $this->approvedRates()->avg('rate');

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
        $rules['area_id'] .= '|' . \Illuminate\Validation\Rule::exists('areas', 'id')->where('type', 'regija');
        return $rules;
    }

    public function update($req = [], $options = []) {
        $this->fill( $req->only( $this->getFillable() ) );
        if ( !$this->save() )
            return false;

        if ( $req->has('languages') )
            if ( !$this->updateTransliterations($req) )
                return false;

        if ( $req->hasFile('logo') ) {
            $this->storeLogo($req->logo);
        }

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        if ( $req->hasFile('video') )
            $this->storeVideo($req->video);

        if ( $req->has('point') )
            $this->storePoint($req->point['lat'], $req->point['lng']);

        if ( $req->has('admins') ) {
            $this->admin()->sync( $req->admins );
        }

        return true;

    }

    public function patchInitialize() {
        parent::patchInitialize();

        $this->rate = $this->approvedRates()->avg('rate');
        $this->rate_count = $this->approvedRates()->count();

        return $this;
    }

    public function postCreation($req = null) {
        $this->makeGallery();

        if ( $req->hasFile('logo') ) {
            $this->storeLogo($req->logo);
        }

        if ( $req->hasFile('cover') )
            $this->storeCover($req->cover);

        if ( $req->hasFile('video') )
            $this->storeVideo($req->video);

        if ( $req->has('point') )
            $this->storePoint($req->point['lat'], $req->point['lng']);

        if ( $req->has('gallery') )
            foreach ($req->gallery as $file)
                $this->addImageToGallery($file);

        if ( $req->has('admins') ) {
            $this->admin()->sync( $req->admins );
        }

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

    public function setPonpetAttribute($value) {
        $this->attributes['ponpet'] = 
            ( is_array($value) ) ? implode($value, ' - ')
                                 : '/';
    }

    public function setSubAttribute($value) {
        $this->attributes['sub'] = 
            ( is_array($value) ) ? implode($value, ' - ')
                                 : '/';
    }

    public function setNedAttribute($value) {
        $this->attributes['ned'] = 
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



}
