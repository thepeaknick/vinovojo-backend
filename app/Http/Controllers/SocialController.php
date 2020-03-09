<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Social;

use Log;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\Topics;
use FCM;
use Laravel\Socialite\Two\GoogleProvider;

class SocialController extends Controller {

    public function approveComment($id) {
        $rate = \App\Rate::find($id);

        if (!$rate)
            return response()->json(['error' => 'Rate does not exist'], 404);

        if ($rate->approve())
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function deapproveComment($id) {
        $rate = \App\Rate::find($id);

        if (!$rate)
            return response()->json(['error' => 'Rate does not exist'], 404);

        if ($rate->deapprove())
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function register(Request $r) {

        if ( !$r->has(['social_type', 'social_key']) ) {
            return response()->json(['error' => 'Invalid request'], 400);
        }
         if ( $r->social_type == 'google' )
             return $this->registerWithGoogle($r);


        $social = Social::loadFromNetwork($r->social_type, $r->social_key,$r);
//        dd($social);
        if ( !$social )
            return response()->json(['error' => 'Invalid token'], 400);

        if ( !$social->save() )
            return response()->json(['error' => 'Database communication error'], 500);

        return response()->json([
            'user_data' => $social,
            'token' => app('auth')->fromUser($social)
        ], 200);
    }

    public function registerWithGoogle(Request $r) {

        $definition['social_type'] = 2;
        $definition['social_id'] = $r->social_id;


        // $s = \App\User::firstOrNew($definition);
//        dd($s);/
        $s=\App\User::where('email','=',$r->email)->first();

        if($s==Null)
        {

            //  user don't exists
            $definition['full_name'] = $r->full_name;
            $definition['social_key'] = $r->social_key;
            $definition['email'] = $r->email;
            $definition['social'] = 1;
            $s=new \App\User($definition);
        }else{
            $socialIdExists=\App\User::where('social_id','=',$r->social_id)->first();
            // var_dump($socialIdExists);
            // die();
            if($socialIdExists!=Null)
            {
                $s->full_name = $r->full_name;
                $s->social_key = $r->social_key;
                $s->email = $r->email;
                $s->social = 1;
            }else{
                if($s->social!='2')
                {
                    $s->full_name=$r->full_name;
                    $s->email = $r->email;
                }else{
                    return response()->json(['message'=>'Invalid creditials'],400);
                }
            }
            //  user exists

        }

        if ( !$s->save() )
            return response()->json(['error' => 'Database communication error'], 500);

        ($r->has('profile_picture'))?$s->profile_picture=$r->profile_picture:null;
        // $s->profile_picture = $r->profile_picture;
        return response()->json([
            'user_data' => $s,
            'token' => app('auth')->fromUser($s)
        ], 200);
    }

    public function loadUserImage($id) {
        $s = \App\User::find($id);

        if ( !$s )
            return response()->json(['error' => 'User not found'], 404);

        return response()->download( $s->profileFullPath() );
    }

    public function notifyUsers(Request $req) {
        if ( !$req->has(['body', 'title']) )
            return response()->json(['error' => 'Incomplete request'], 422);

        $options = new OptionsBuilder;
        $options->setTimeToLive(60 * 5);

        $notification = new PayloadNotificationBuilder($req->title);
//        $notification->setBody($req->body)
//            ->setSound('default');

        $data = new PayloadDataBuilder();
        $data->addData( ['click_action' => 'notification_info', 'sound' => 'Enabled', 'data' => $req->only(['title', 'body']) ]);

        $options = $options->build();
        $notification = $notification->build();
        $data = $data->build();

        $topic = new Topics();
        $topic->topic('standard')->andTopic(function ($condition) use ($req) {
            $hasTopic = false;
            if ($req->android == 1) {
                $condition->topic('android');
                $hasTopic = true;
            }

            if ($req->ios == 1) {
                if ($hasTopic)
                    $condition->orTopic('ios');
                else
                    $condition->topic('ios');
            }
        });

        $response = FCM::sendToTopic($topic, $options, null, $data);

        $this->notifyUsersWithoutData($req);

        if ( $response->isSuccess() )
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function notifyUsersWithoutData(Request $req) {
        if ( !$req->has(['body', 'title']) )
            return response()->json(['error' => 'Incomplete request'], 422);

        $options = new OptionsBuilder;
        $options->setTimeToLive(60 * 5);

        $notification = new PayloadNotificationBuilder($req->title);
        $notification->setBody($req->body)
            ->setSound('default');

        $data = new PayloadDataBuilder();
//        $data->addData( ['click_action' => 'notification_info', 'sound' => 'Enabled', 'data' => $req->only(['title', 'body']) ]);

        $options = $options->build();
        $notification = $notification->build();
        $data = $data->build();

        $topic = new Topics();
        $topic->topic('standard')->andTopic(function ($condition) use ($req) {
            $hasTopic = false;
            if ($req->android == 1) {
                $condition->topic('android');
                $hasTopic = true;
            }

            if ($req->ios == 1) {
                if ($hasTopic)
                    $condition->orTopic('ios');
                else
                    $condition->topic('ios');
            }
        });

        $response = FCM::sendToTopic($topic, $options, $notification, null);

        if ( $response->isSuccess() )
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function criticalNotification(Request $req) {
        if ( !$req->has(['body', 'title']) )
            return response()->json(['error' => 'Incomplete request'], 422);

        $options = new OptionsBuilder;
        $options->setTimeToLive(60 * 5);
        $notification = new PayloadNotificationBuilder($req->title);
        $notification
            ->setBody($req->body)
            ->setSound('default');

        $data = new PayloadDataBuilder();
//        $data->addData(['click_action' => 'notification_info', 'sound' => 'default', 'data' => $req->only(['title', 'body']) ]);

        $options = $options->build();
        $notification = $notification->build();
        $data = $data->build();

        $topic = new Topics();
        $topic->topic('critical')->andTopic(function ($condition) use ($req) {
            $hasTopic = false;
            if ($req->android == 1) {
                $condition->topic('android');
                $hasTopic = true;
            }

            if ($req->ios == 1) {
                if ($hasTopic)
                    $condition->orTopic('ios');
                else
                    $condition->topic('ios');
            }
        });

        $response = FCM::sendToTopic($topic, $options, $notification, $data);

        if ( $response->isSuccess() )
            return response()->json(['message'=>'Notification sent'], 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function wineComments($wineId) {
        if ( is_null( app('auth')->user() ) )
            return (new WineController)->loadWineComements($wineId);

        $wine = \App\Wine::where('id', $wineId)->first();

        if (!$wine)
            return response()->json(['error' => 'Wine not found'], 404);

        $comments = $wine->rates()
            ->where(function ($query) {
                $query->where('status', 'approved');
                $query->orWhere(function ($query) {
                    $query->where('status', '!=', 'approved');
                    $query->where('user_id', app('auth')->user()->id);
                });
            })
            ->with('user')
            ->latest('created_at')
            ->get()
            ->paginate(10);

        return response()->json($comments, 200);
    }

    public function wineCommentsAll()
    {
        $wines=\App\Wine::all();
        $comments=[];
        foreach ($wines as $wine) {
            $comments[]=$this->wineComments($wine->id);
        }
        if($comments)
            return response()->json($comments,200);
        else return response()->json(['message'=>'not found'],404);
    }

    public function wineryComments($wineryId) {
        if ( is_null( app('auth')->user() ) )
            return (new WineryController)->loadWineryComments($wineryId);

        $winery = \App\Winery::where('id', $wineryId)->first();

        if (!$winery)
            return response()->json(['error' => 'Winery not found'], 404);

        $comments = $winery->rates()
            ->where(function ($query) {
                $query->where('status', 'approved');
                $query->orWhere(function ($query) {
                    $query->where('status', '!=', 'approved');
                    $query->where('user_id', app('auth')->user()->id);
                });
            })
            ->with('user')
            ->latest('created_at')
            ->get()
            ->paginate(10);

        return response()->json($comments, 200);
    }

    public function wineryCommentsAll()
    {
        $winaries=\App\Winery::all();
        $comments=[];
        foreach ($winaries as $winery) {
            $comments[]=$this->wineComments($winery->id);
        }
        if($comments)
            return response()->json($comments,200);
        else return response()->json(['message'=>'not found'],404);
    }

}
