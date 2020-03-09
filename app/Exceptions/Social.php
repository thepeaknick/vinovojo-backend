<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

use GuzzleHttp\Client;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Social extends BaseModel implements JWTSubject, AuthenticatableContract {

    use Authenticatable;

    public $timestamps = false;

    protected $fillable = [
        'social_id', 'social_type', 'social_key'
    ];

    protected $storageDisk = 'socials';

    protected $dates = [];

    public static $rules = [

    ];

    protected $typeCast = [
        'instagram', 'facebook', 'google'
    ];

    protected $appends = [
        'profile_picture'
    ];



    //      -- Relationships --

    public function favourites() {
        return $this->hasMany('App\Favourite', 'social_id');
    }



    //      -- Accessors --

    public function getSocialTypeAttribute($value) {
        return $this->typeCast[$value];
    }

    public function getProfilePictureAttribute() {
        return route('profile_pic', ['id' => $this->id]);
    }



    //      -- Mutators --

    public function setSocialTypeAttribute($value) {
        if ( is_integer($value) && $value < count($this->typeCast) ) 
            return $this->attributes['social_type'] = $value;
        
        $index = array_search($value, $this->typeCast);
        if ( !$index )
            return null;

        $this->attributes['social_type'] = $index;
        return $index;
    }

    public function setProfilePictureAttribute($url) {
        return ( empty($url) ) ? true : $this->saveProfile($url);
    }



    //      -- Custom methods -- 

    public static function convertType($type) {
        $cast = with(new static)->typeCast;

        return ( is_int($type) ) ? $cast[$type] : array_search($type, $cast);
    }

    public function saveProfile($image) {
        try {
            $image = Image::make($image);
        } catch(Intervention\Image\Facades\Image\NotReadableException $e) {
            return false;
        }
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


        // JWT



    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return ['type' => 'social'];
    }

    public function loginToken() {
        return JWTAuth::fromUser($this);
    }


        // Instantiation methods

    public static function loadFromNetwork($type, $key) {
        return ($type == 'instagram') ? static::loadFromInstagram($key) : static::loadWithSocialite($type, $key);
    }

    private static function loadFromInstagram($key) {
        $guzzle = new Client(['http_errors' => false]);
        $post = [
            'client_id' => config('services.instagram.client_id'),
            'client_secret' => config('services.instagram.client_secret'),
            'redirect_uri' => config('services.instagram.redirect_uri'),
            'grant_type' => config('services.instagram.grant_type'),
            'code' => $key
        ];
        $response = $guzzle->post( config('services.instagram.request_url'), ['form_params' => $post] );

        if ( $response->getStatusCode() != 200) {
            \Log::info( 'Zahtev Instagramu nije proso', json_decode($response->getBody(), 1) );
            return false;
        }

        $body = json_decode( $response->getBody(), 1 );
        $user = $body['user'];

        $s = static::instantiateSocialFromUser($user, 'instagram');
        $s->social_key = $key;

        return $s;        
    }

    private static function loadWithSocialite($type, $key) {
        $user = \Socialite::driver( $type )->userFromToken($key);
        if ( !$user )
            return false;

        $definition['social_type'] = static::convertType( $type );
        $definition['social_id'] = $user->id;

        $s = static::instantiateSocialFromUser($user, $type);
        $s->social_key = $key;

        return $s;
    }

    private static function instantiateSocialFromUser($user, $type) {
        $user = (object) $user;

        $definition['social_type'] = static::convertType( $type );
        $definition['social_id'] = $user->id;


        $s = \App\User::firstOrNew( $definition );

        \Log::info($type, (array) $user);

        $s->full_name =  ($type == 'instagram') ? $user->full_name : $user->name;
        $s->social_id = $user->id;
        // $s->social_type = $type;
        $s->email = ($type == 'instagram') ? $user->username : $user->email;

        $s->social = 1;

        $s->save();

        $s->profile_picture = ($type == 'instagram') ? $user->profile_picture : $user->avatar;


        return $s;
    }

}
