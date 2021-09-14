<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Category extends BaseModel {

    protected $table = 'wine_categories';

    protected static $listData = [
        'wine_categories.id as id', 'transliteration.value as name'
    ];

    protected $fillable = [
        'id', 'name'
    ];

    protected $appends = [
        'cover_image', 'wine_count'
    ];

    protected $hidden = [
        'transliterations'
    ];

    public $rules = [
        'languages' => 'required|array|min:1'
    ];

    protected $storageDisk = 'wines';



    //      -- Relationships --

    public function wines() {
        return $this->hasMany('App\Wine');
    }



    //		-- Accessors --

    public function getCoverImageAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'category', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 7;
    }

    //      -- Wine properties
    public function getHarvestYearAttribute()
    {
        $year = $this->wines->pluck('harvest_year')->toArray();
        return array_values(array_unique($year));
    }

    public function getClassesAttribute()
    {
        $wines = $this->wines->pluck('id')->toArray();
        $classes = DB::table('classes_wines')->whereIn('wine_id', $wines)->select('class_id')->get()->toArray();
        $ids=[];
        foreach ($classes as $class) {
            $ids[]= $class->class_id;
        }
        return array_values(array_unique($ids));
    }

    public function getAlcoholAttribute()
    {
        $alcohol = $this->wines->pluck('alcohol')->toArray();
        return array_values(array_unique($alcohol));
    }



    //      -- Custom methods --

    protected function coverDiskPath() {
        return 'categories/' . $this->id;// . '.png';
    }



    //      -- CRUD override --

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {
        $query = static::select( static::$listData,true );
        $query->join('text_fields as transliteration', function ($query) use ($languageId) {
            $stat = new static;
            $query->on('transliteration.object_id', '=', $stat->getTable() . '.id');
            $query->where('transliteration.object_type', '=', $stat->flag);
            $query->where('transliteration.name', 'name');
            $query->where('transliteration.language_id', $languageId);
        });

        $request = app('request');
        if ($getQuery)
            return $query;
        $categories = $query->get();

        $categories->transform(function($category) {
            $category->wine_count = $category->wines()->count();
            return $category;
        });

        if ($request->header('Sort-By')) {
            if ($request->header('Sorting', 'desc') === 'asc') {
                $categories = $categories->sortBy($request->header('Sort-By'))->values();
            } else {
                $categories = $categories->sortByDesc($request->header('Sort-By'))->values();
            }
        }

        return $categories;
    }

    public function update($req = [], $options = []) {
        parent::update($req);

        if ($req->hasFile('cover'))
            $this->storeCover($req->cover);

        return true;
    }

    public function postCreation($req = null) {
        if ($req->hasFile('cover'))
            $this->storeCover($req->cover);

        return true;
    }

    public function getWineCountAttribute()
    {
        return $this->wines()->count();
    }

    public static function dropdown($langId = null)
    {
        if(!isset($langId))
            $langId = 1;

        $data = parent::dropdown($langId);
        $data->each(function ($item) {
            $item->append('harvest_year', 'classes', 'alcohol');
        });
        $data->setVisible('id', 'name','harvest_year', 'classes', 'alcohol');

        return $data;
    }

}
