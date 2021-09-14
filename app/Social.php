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
use Illuminate\Http\Request as Request;

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

    public static function loadFromNetwork($type, $key,Request $r) {
        return ($type == 'instagram') ? static::loadFromInstagram($key) : static::loadWithSocialite($type, $key,$r);
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
//        $response = $guzzle->post( config('services.instagram.request_url'), ['form_params' => $post] );
        try{
            $response=$guzzle->get('https://api.instagram.com/v1/users/self/?access_token='.$key);
//            dd($response);
            $user=json_decode($response->getBody()->getContents())->data;
            $user->social_id=$user->id;
            if ( $response->getStatusCode() != 200) {
                \Log::info( 'Zahtev Instagramu nije proso', json_decode($response->getBody(), 1) );
                return false;
            }

            $body = json_decode( $response->getBody(), 1 );
    //        $user = $body['user'];
    //        dd($user);

            $s = static::instantiateSocialFromUser($user, 'instagram');
            $s->social_key = $key;

            return $s;

        }catch (\Exception $e) {
            return false;
        }
//            $data=
//            \Log::info('Response ',array($response));
    }

    private static function loadWithSocialite($type, $key,Request $r) {
        if($type=='facebook')
            return static::loadFromFacebook($r, $key);
        $user = \Socialite::driver( $type )->userFromToken($key);

//        dd($user);

//        $user=$r->only(['social_id','email','avatar','name','social_key']);
        // dd($user);
//        $user['social_id']=$user['social_id'];

//        $user['name']=$user['name'];



//        $user=(object) $user;
//
//        $def['social_type'] = static::convertType( $type);
//        $def['social_id'] = $user->social_id;
//
//        $usr=\App\User::firstOrUpdate($def);
//        dd($usr);

        // $user['avatar']=$user['avatar'];


        // if ( !$user )
        //     return false;

        // $definition['social_type'] = static::convertType( $type );
        // $definition['social_id'] = $user->id;

        // $s = static::instantiateSocialFromUser($user, $type);
        // $s->social_key = $key;

        // return $s;

        return static::instantiateSocialFromUser($user,$type);
    }

    public static function loadFromFacebook(Request $r, $key){
        $soc_user= \Socialite::driver( 'facebook' )->userFromToken($key);


        if(!$r->has('social_id') || !$r->has('social_type'))
        return false;

        $soc_type= static::convertType($r->social_type);
        $user= User::where('social_id',$r->social_id)
                    ->where('social_type',$soc_type)
                    ->first();

//        \Log::info('Soc_user: ',(array)$soc_user);
//        \Log::info('User prije: ',(array)$user);

        if($user==null)
        {
            $user= new User;
            $user->social_type= $r->social_type;
            $user->social_id=$r->social_id;
            $user->email=(isset($soc_user->email))?$soc_user->email:null;
            $user->full_name=$soc_user->user['name'];
            $user->social_key=$r->social_key;
            $user->social=1;
//            if($user->hasProfile()) {
//                \Log::info('Profilna user-a: ',['profile'=> $user->profile_picture]);
//            }
//            if(!$user->hasProfile())
            $user->save();
                $user->saveProfile($soc_user->avatar);
            if(!$user->save())
                return false;

        }

        if($user!==null){
            $user->social_type= '1';
            $user->save();
        }
//        \Log::info('User poslije: ',(array)$user);

        return $user;
    }

    private static function instantiateSocialFromUser($ref_user, $type) {
        $user = (object) $ref_user->user;
        var_dump($ref_user);

        $definition['social_type'] = static::convertType( $type );

        $definition['social_id']=($type=='google')?$user->id : $ref_user->social_id;

//        dd($user->user);

//        dd($type);


        if($type=='instagram')
            $s = \App\User::firstOrNew( $definition );
        else{
            $data=[
                'full_name'     => $user->name,
                'social_type'   => $type,
                'email'         => $user->email,
                'social'        => 1,
                'social_type'   => $definition['social_type'] ,
                'social_id'     => $definition['social_id']
            ];
            $s= \App\User::where('social_id',' = ',$definition['social_id'])->where('email' , ' = ' , $user->email)->first();
            if($s) {
                return $s->save();
            }
            $s=\App\User::firstOrNew( $data );
            return $s;

        }


        $s->full_name =  ($type == 'instagram') ? $user->full_name : $user->name;
        $s->social_type = $type;
        $s->email = ($type == 'instagram') ? $user->username : $user->email;

        $s->social = 1;

        $s->save();

        $s->profile_picture = ($type == 'instagram') ? $user->profile_picture : $user->avatar;


        return $s;
    }

}
