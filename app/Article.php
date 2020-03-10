<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Article extends BaseModel
{

    protected static $listData = [
        'articles.id as id', 'created_at', 'link', 'nameTransliteration.value as name', 'textTransliteration.value as text'
    ];

    // public static $listTransliteration = [
    //     'name', 'text'
    // ];

    protected $fillable = [
        'name', 'text', 'link'
    ];

    protected $hidden = [
        'transliterations'
    ];

    protected $appends = [
        'image_path', 'flag'
    ];

    public $rules = [
        'link' => 'sometimes|url',
        'languages' => 'required|array|min:1'
    ];

    protected $storageDisk = 'news';



    //      -- CRUD override --

    public static function list($lang, $sorting = 'asc', $getQuery = false,$search='',$sortBy=false) {
        $q = parent::list($lang, $sorting, true)
                    ->join('text_fields as nameTransliteration', function ($q) use ($lang,$search) {
                            $q->on('nameTransliteration.object_id', '=', 'articles.id');
                            $q->where('nameTransliteration.object_type', (new static)->flag);
                            $q->where('nameTransliteration.name', 'name');
                            $q->where('nameTransliteration.language_id', $lang);
                        })
                    ->leftJoin( 'text_fields as textTransliteration', function ($q) use ($lang) {
                            $q->on('textTransliteration.object_id', '=', 'articles.id');
                            $q->where('textTransliteration.object_type', (new static)->flag);
                            $q->where('textTransliteration.name', 'text');
                            $q->where('textTransliteration.language_id', $lang);
                    });
        $req= app('request');
        if($req->has('search'))
            $q->where('nameTransliteration.value', 'like', '%'.$req->search.'%');

        return ($getQuery) ? $q : $q->paginate(10);
    }



    //      -- CRUD complementary methods --

    public function postCreation($req = null) {
        if ( $req->hasFile('cover') )
            $this->storeCover( $req->cover );

        return true;
    }



    //      -- Accessors --

    public function getImagePathAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'article', 'id' => $this->id, 'antiCache' => time()]) : null;
    }

    public function getFlagAttribute() {
        return 1;
    }

    public function update($req = [], $options = []) {
        /*if (parent::update($req, $options))
            return false;*/

            parent::update($req);

        if ($req->hasFile('cover')) {
            $this->storeCover($req->cover);
        }

        return true;
    }

}
