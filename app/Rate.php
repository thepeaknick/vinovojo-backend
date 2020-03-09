<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;

use Intervention\Image\ImageManagerStatic as Image;

class Rate extends BaseModel {

    protected $fillable = [
    	'rate', 'comment', 'user_id', 'object_id', 'object_type'
    ];

    protected $hidden = [
    	'object_type', 'object_id', 'updated_at', 'user_id', 'user_type'
    ];

    protected $dates = [];

    protected $appends = [
    	'cover_image'
    ];

    public $rules = [
        'user_id' => 'numeric|exists:users,id|required',
        'comment' => 'string',
        'rate' => 'numeric|min:0|max:5|nullable',
        'object_id' => 'numeric|required',
        'object_type' => 'numeric|required|min:2|max:3'        
    ];



    //      -- Relationships -- 

    public function user() {
        return $this->belongsTo('\App\User', 'user_id')->select('id', 'full_name', 'social_type', 'type');
    }

    public function object() {
        $rel = ( $this->object_type == app('\App\Winery')->flag ) ? 'App\Winery' : 'App\Wine';
        return $this->belongsTo($rel, 'object_id');
    }



    //		-- Accessors 

    public function getCoverImageAttribute() {
        return ( $this->hasCoverImage() ) ? route('cover_image', ['object' => 'rate', 'id' => $this->id, 'antiCache' => time()]) : null;
    }



    //		-- Custom methods --

    public function storePath($file = null) {


    	$path = 'comment_' . $this->id . '.' ;
    	$path .= ( is_null($file) ) ? '*' :  $file->guessExtension();
    	return $path;
    }

    public function hasCoverImage($getPath = false) {
    	$glob = glob( Storage::disk('rates')->path( $this->storePath() ) );

    	if ( count($glob) < 1 )
    		return false;
        
        return ($getPath) ? $glob[0] : true;
    }

    public function coverFullPath() {
    	return $this->hasCoverImage(true);
    }

    public function approve() {
        $this->status = 'approved';
        return $this->save();
    }

    public function deapprove() {
        $this->status = 'unapproved';
        return $this->save();
    }



    //		-- CRUD override --

    public function postCreation($req = null) {
        \Log::info('Mitin zahtev', $req->all());
      
        if ( $req->has('image') ) {
            try {
                $image = Image::make($req->image);
                if ( $image->width() > 1024)
                    $image->resize(1024, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                //$image->save( $this->storePath($req->image) );
                $image->save( Storage::disk('rates')->path( $this->storePath($req->image)));
                
            } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
                
            }
        }

        $user = app('auth')->user();

        if ( $user->isTrusted() ) 
            $this->approve();

        if ($user->approvedComments()->count() >= 3)
            $user->makeTrusted();

        // $mail = new \App\Mail\RateCreatedMail($this->object);
        // $addresses = \App\User::where('type', 'admin')->pluck('email');
        // Mail::to($addresses)->send($mail);

        return true;
    }

    public function preCreate($req = null) {
        $user_id = app('auth')->user()->id;
        $req->request->add(['user_id' => $user_id]);
        return true;
    }

    public function update($req = [], $options = []) {
        if ( !parent::update($req) )
            return false;

        if ( $req->has('image') ) {
            try {
                $image = Image::make($req->image);
                if ( $image->width() > 1024)
                    $image->resize(1024, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $image->save( $this->coverFullPath() );
            } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
                
            }
        }

        return true;
    }

    



    //      -- Validation --

    public function validatesBeforeCreation() {
        return true;
    }

}
