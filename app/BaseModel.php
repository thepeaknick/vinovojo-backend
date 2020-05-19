<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class BaseModel extends Model
{

    protected static $listRelationships = [];

    protected static $listData = ['id'];

    public static $listTransliteration = ['name'];

    public static $transliteratesLists = true;

    protected $relationships = [];

    protected static $listSort = 'name';



    //      -- Base methods --

    public static function list($lang, $sorting = 'asc', $getQuery = false) {
    	$q = static::select( static::$listData )->with( static::$listRelationships );
        //$q->orderBy( static::$listSort, $sorting );

        if ($getQuery)
            return $q;

        $data = $q->paginate(10);
        if ( static::$transliteratesLists )
            $data->transliterate($lang, static::$listTransliteration );

        return $data;
    }

    public static function search($param, $languageId, $getQuery = false) {
        $i = new static;
        $selects = [
            $i->getTable() . '.id as id',
            'transliteration.value as name'
        ];
        $query = static::select($selects);

        $query->join( (new \App\TextField)->getTable() . ' as transliteration', function ($q) use ($languageId, $i) {
            $q->on('transliteration.object_id', '=', $i->getTable() . '.id');
            $q->where('transliteration.object_type', $i->flag);
            $q->where('transliteration.name', 'name');
            $q->where('transliteration.language_id', $languageId);
        });
        $query->where('transliteration.value', 'like', '%' . $param . '%');

        if ($getQuery)
            return $query;

        $data = $query->get();
        $data->setVisible('id', 'name');
        return $data;
    }

    public static function dropdown($langId = null) {
        if ( static::$transliteratesLists ) {
            $i = new static;
            $table = $i->getTable();
            $data = static::select( $table . '.id as id', 'transliteration.value as name' )
                           ->join( (new \App\TextField)->getTable() . ' as transliteration', function ($query) use ($i, $table, $langId) {

                                $query->on( 'transliteration.object_id', '=', $table . '.id' );
                                $query->where('transliteration.object_type', $i->flag);
                                $query->where('transliteration.name', 'name');
                                if ( !is_null($langId) )
                                    $query->where('language_id', $langId);
                           })
                           ->orderBy('name', 'asc')
                           ->get();
            $data->setVisible(['id', 'name']);
            return $data;
        }
        return static::select('name', 'id')->orderBy('name', 'asc')->get();
    }

    public function singleDisplay($languageId = null) {
        if ( property_exists($this, 'relationships') )
            $this->load($this->relationships);

//        dd($this->relationships);
//        if( property_exists($this, 'logo'))
//            $this->setAppends(['logo']);
        return $this;
    }

    public function patchInitialize() {
        $this->load( $this->relationships );

        $transliterations = $this->transliterations()->with('language')->get();

        $this->languages = $transliterations->groupBy('language_id')->transform( function ($field) {

            $language = $field->first()->language->name;
            $id = $field->first()->language->id;

            $fields = $field->transform( function ($f) {
                return $f->only(['id', 'name', 'value']);
            });

            return collect([
                'language' => $language,
                'language_id' => $id,
                'fields' => $fields
            ]);

        })->values();

        return $this;
    }

    // We need this method in case some model needs access to the full request instance upon updating (eg. save a file from request)
    public function update($req = [], $options = []) {
        if ( !parent::update( $req->except('languages'), $options ) )
            return false;

        if ( $req->has('languages') )
            return $this->updateTransliterations( $req );

        return true;
    }



    //      -- Transliteration --

    public function updateTransliterations( $r ) {
        $langs = $r->languages;

        foreach ($langs as $lang) {
            if ( empty($lang['id']) ) {
                $txt = new \App\TextField($lang);
                $txt->object_type = $this->flag;
                $txt->object_id = $this->id;

                if (!$txt->save())
                    return false;

                continue;
            }
            \App\TextField::where('id', $lang['id'])->update( [ 'value' => $lang['value'] ] );
        }

        return true;
    }

    public function transliterate($languageId = null, $attributes = []) {
        if ( is_null($languageId) )
            $languageId = \App\Language::getLanguageFromLocale();

        if ( $this->languageLoaded($languageId) ) {

            $fields = $this->transliterations->where('language_id', $languageId);

        }

        else {

            $query = $this->transliterations()->where('language_id', $languageId)->select('name', 'value', 'language_id');
            $query->where(function ($q) use ($attributes) {
                foreach ($attributes as $attr)
                    $q->orWhere('name', $attr);
            });

            $fields = $query->get();

        }

        if ($fields->isEmpty())
            return null;

        $fields = $fields->keyBy('name')->transform( function ($f) { return $f->value; });
        $this->fill( $fields->all() );

        return $this;
    }

    protected function languageLoaded($languageId) {
        if ( !$this->relationLoaded('transliterations') )
            return false;

        return $this->transliterations->where('language_id', $languageId)->count() > 0;
    }

    public function saveLanguages( $languages ) {
        $fields = [];
        foreach ($languages as $field) {
                $definition = [
                    'language_id' => $field['language_id'],
                    'name' => $field['name'],
                    'object_id' => $this->id,
                    'object_type' => $this->flag
                ];
                $txt = \App\TextField::firstOrNew($definition);
                $txt->value = $field['value'];
                if ( !$txt->save() )
                    return false;
        }
        return true;
    }

    public function deleteLanguage( $languageId ) {
        $languageId = ( $languageId instanceof \App\Language ) ? $languageId->id : $languageId;

        \App\TextField::where('object_type', $this->flag)
                     ->where('object_id', $this->id)
                     ->where('language_id', $languageId)
                     ->delete();

        return true;
    }



    //      -- Relationships --

    public function transliterations() {
        return $this->hasMany('App\TextField', 'object_id')->where('object_type', $this->flag);
    }

    public function availableLanguages() {
        return $this->transliterations()
                    ->select('languages.name as name', 'languages.id as id', 'text_fields.object_id as object_id')
                    ->join('languages', 'languages.id', '=', 'text_fields.language_id')
                    ->groupBy('id');

    }



    //      -- Validation methods --

    public function validatesBeforeUpdate() {
    	return false;
    }

    public function validatesBeforeCreation() {
        return false;
    }

    public function getRules() {
        return $this->rules;
    }

    public function preCreate($req) {
        return true;
    }

    public function postCreation($req = null) {
        return true;
    }

    public function postDelete() {
        if ( $this->hasCoverImage() )
            return $this->deleteCoverImage();

        return true;
    }

    public function delete() {
        return parent::delete() && $this->postDelete();
    }



    //      -- Images --

    public function hasCoverImage() {
        return Storage::disk($this->storageDisk)->exists( $this->coverDiskPath() );
    }

    protected function coverDiskPath() {
        return 'covers/' . $this->id;
    }

    public function coverFullPath() {
        return Storage::disk( $this->storageDisk )->path( $this->coverDiskPath() );
    }

    public function storeCover( $image ) {

        if($image==null)
            return $this->deleteCoverImage();

        try {
            $image = Image::make($image);
            $image->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
            \Log::info('nije uspio da sacuva sliku ',(array)$e);
            return false;
        }
        return $image->save( $this->coverFullPath() );
    }

    public function deleteCoverImage() {
        return Storage::disk( $this->storageDisk )->delete( $this->coverDiskPath() );
    }



    //      -- Location --

    public function storePoint($lat, $lng) {
        $point = Pin::where('object_id', $this->id)
                          ->where('object_type', $this->flag)
                          ->first();
        if ($point) {
            $point->lat = $lat;
            $point->lng = $lng;
            $point->save();
            return $point;
        }
        $point = new \App\Pin(['object_id' => $this->id, 'object_type' => $this->flag]);
        $point->lat = $lat;
        $point->lng = $lng;
        return $point->save();
    }



    //      -- Custom methods --

    public function only($values = []) {
        $values = ( is_object($values) ) ? $values->all() : $values;
        $currentVisible = $this->getVisible();
        
        $this->setVisible( $values );
        $return = $this->toArray();

        $this->setVisible($currentVisible);

        return collect( $return );
    }

    public function incrementSearch($save = true) {
        $this->search_count++;
        return !$save ?: $this->query()
                              ->where($this->getKeyName(), $this->getKey())
                              ->update(['search_count' => $this->search_count]);
    }

}
