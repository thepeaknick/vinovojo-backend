<?php 

namespace App;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManagerStatic as Image;

class File extends BaseModel {

    protected $fillable = [];

    protected $dates = [];

    public $timestamps = false;

    protected $hidden = [
    	'path', 'winery_id', 'winery'
    ];

    protected $appends = [
    	'url'
    ];

    public static $rules = [
        // Validation rules
    ];

    public $storageDisk = 'wineries';


    // Relationships 
    
    public function winery() {
    	return $this->belongsTo(\App\Winery::class);
    }


    // Accessors 
    
    public function getFullPathAttribute() {
    	return $this->path . DIRECTORY_SEPARATOR . $this->filename;
    }

    public function getUrlAttribute() {
    	return route('gallery_image', ['id' => $this->id, 'wineryId' => $this->winery->id]);
    }


    public function storeFile($file) {
        $extension = pathinfo($file->getClientOriginalName())['extension'];
        if ($extension == 'jpg' || $extension == 'png') {
            try {
                $image = Image::make($file);
                if ($image->width() > 1024)
                    $image->resize(1024, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $path = $this->galleryPath( $file->getClientOriginalName() );
                $image->save( $path );
            } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
                return false;
            }
        }
        else {
            $file->storeAs($this->galleryDiskPath(), $file->getClientOriginalName(), $this->storageDisk);
            $path = $this->galleryPath( $file->getClientOriginalName() );
        }
    	$this->path = pathinfo($path)['dirname'];
    	$this->filename = pathinfo($path)['basename'];
    	return $this->save();
    }

    public function deleteFromDisk() {
    	return unlink( $this->fullPath );
    }

    public function galleryPath($addition = null) {
        return Storage::disk( $this->storageDisk )->path( $this->galleryDiskPath($addition) );
    }

    private function galleryDiskPath($addition = null) {
        $path = 'galleries/' . $this->winery->id;
        return ( is_null($addition) ) ? $path : $path . '/' . $addition;
    }

    public function delete() {
    	parent::delete();
        static::shiftLeft( $this->winery->fileAvailablePosition(), $this->position );
    	$this->deleteFromDisk();
    }

    public function reposition($newPosition) {
        if ($newPosition > $this->position) {
            static::shiftLeft($newPosition);
        }
        else {
            static::shiftRight($newPosition, $this->position);
        }
        $this->position = $newPosition;
        return $this->save();
    }

    public static function shiftLeft($from, $to = null) {
        $query = static::where('position', '<=', $from);
        if (!is_null($to)) {
            $query->where('position', '>=', $to);
        }
        return $query->update(['position' => DB::raw('position - 1')]);
    } 

    public static function shiftRight($from, $to = null) {
        $query = static::where('position', '>=', $from);
        if (!is_null($to)) {
            $query->where('position', '<=', $to);
        }
        return $query->update(['position' => DB::raw('position + 1')]);
    }

}
