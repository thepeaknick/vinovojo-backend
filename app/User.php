<?php

namespace App;

use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Support\Facades\Storage;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    public static $transliteratesLists = false;

    protected $fillable = [
        'full_name', 'phone_number', 'email', 'password', 'social', 'social_key', 'social_type', 'social_id', 'type'
    ];

    protected $relationships = [
        'winery'
    ];

    protected static $listData = ['id', 'full_name'];

    protected static $listSort = 'full_name';

    protected $hidden = [
        'password', 'transliterations'
    ];

    public $rules = [
        'full_name' => 'string|required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8'
    ];

    protected $appends = [
        'profile_picture'
    ];



    //      -- Accessors --

    public function getProfilePictureAttribute() {
        return route('profile_pic', ['id' => $this->id]);
    }



    //      -- Relationships --

    public function favourites() {
        return $this->hasMany('App\Favourite', 'social_id');
    }

    public function comments() {
        return $this->hasMany('App\Rate');
    }

    public function approvedComments() {
        return $this->comments()->where('status', 'approved');
    }

    public function winery() {
        return $this->belongsToMany('App\Winery');
    }

    public function rate()  {
        return $this->belongsToMany('\App\Rate');
    }



    //      -- Mutators --

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = app('hash')->make($value);
    }

    public function setProfilePictureAttribute($url) {
        return ( empty($url) ) ? true : $this->saveProfile($url);
    }

    // public function getRoleAttribute() {
    //     return $this->attributes['role'];
    // }



    //      -- Validation --

    public function validatesBeforeCreation() {
        return true;
    }

    public function validatesBeforeUpdate() {
        $user = $this;
        $this->rules = [
            'name' => 'string',
            'email' => 'string|unique:users,email',
            'password' => 'filled|bail|string|min:8',
//            'old_password' => function($attribute, $oldPassword, $fail) use ($user) {
//                if ( !$user->checkPassword($oldPassword) )
//                    return $fail('Old password incorrect');
//            }
        ];
        return true;
    }



    //      -- JWTSubject implementation --

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }



    //      -- Custom methods --

    public function checkPassword($pass) {
        return app('hash')->check($pass, $this->password);
    }

    public function saveProfile($image) {
        try {
            $image = Image::make($image);
            $image->resize(320, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
            \Log::info((array)$e);
            return false;
        }
//        if($this->profileExists());
//        dd($this->profileFullPath(true));
        if(file_exists($this->profileFullPath(true)))
            unlink($this->profileFullPath(true));
        return $image->save( $this->profileFullPath(true) );
    }

    public function hasProfile() {
        return Storage::disk( $this->storageDisk )->exists( $this->profileDiskPath() );
    }

    public function profileFullPath($realPath = false) {
        if ( $this->hasProfile() || $realPath )
            return Storage::disk( $this->storageDisk )->path( $this->profileDiskPath() );

        return Storage::disk( $this->storageDisk )->path( $this->defaultProfileDiskPath() );
    }

    protected function profileDiskPath() {
        return 'profiles/' . $this->id;// . '.jpg';
    }

    private function defaultProfileDiskPath() {
        return 'profiles/default.jpg';
    }

    public function makeTrusted() {
        if ($this->type == 'trusted' || $this->type == 'admin')
            return true;

        $this->type = 'trusted';
        return $this->save();
    }

    public function isTrusted() {
        return $this->type == 'trusted' || $this->type == 'admin';
    }



    public function update($req = [], $options = []) {
        if (!parent::update($req, $options))
            return false;

        return $this->postCreation($req);
    }

    public function postCreation($req = null) {
        if($req->has('profile_picture'))
            $this->saveProfile($req['profile_picture']);

        if ($req->has('wineries') && $req['wineries']!=="")
            $this->winery()->sync($req->wineries);

        return true;
    }

    public function clear(){
        $rates=\App\Rate::where('user_id',$this->id)->get();
        // var_dump(count($rates));
        // dd($rates);
        if(count($rates)!==0){
            foreach($rates as $rate){
                // dd($rate);
                $instance=\App\Rate::findOrFail($rate->id);
                $instance->delete();
            }
        }

        $userInstance=$this;
        // dd($userInstance);
        if($userInstance->destroy($this->id))
            return true;
        return false;
    }

    public static function listWithSearch($lang, $sorting = 'ASC', $getQuery = false, $search='', $sortBy='name' )
    {
        $data= static::list($lang, $sorting, true);
        if($search!=='')
            $data->where('full_name','like','%'.$search.'%');
        $data->orderBy('full_name',$sorting);
        return $data->get();
    }

}
