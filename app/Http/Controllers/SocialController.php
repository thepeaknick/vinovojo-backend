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
        
        if ( !$r->has(['social_type', 'social_key', 'social_type']) ) {
            return response()->json(['error' => 'Invalid request'], 400);
        }
        
        if ( $r->social_type == 'google' )
            return $this->registerWithGoogle($r);


        $social = Social::loadFromNetwork($r->social_type, $r->social_key);

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

        $s = \App\User::firstOrNew($definition);

        $s->full_name = $r->full_name;
        $s->social_key = $r->social_key;
        $s->email = $r->email;
        $s->social = 1;

        if ( !$s->save() )
            return response()->json(['error' => 'Database communication error'], 500);

        $s->profile_picture = $r->profile_picture;

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
        $notification->setBody($req->body)
                     ->setSound('default');

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
                    $condition->orTopic('android');
                else
                    $condition->topic('android');
            }
        });

        $response = FCM::sendToTopic($topic, $options, $notification, $data);

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
        $notification->setBody($req->body)
                     ->setSound('default');

        $data = new PayloadDataBuilder();
        $data->addData(['click_action' => 'notification_info', 'sound' => 'Enabled', 'data' => $req->only(['title', 'body']) ]);

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
                    $condition->orTopic('android');
                else
                    $condition->topic('android');
            }
        });

        $response = FCM::sendToTopic($topic, $options, $notification, $data);

        if ( $response->isSuccess() )
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function wineComments($wineId) {
        if ( is_null( app('auth')->user() ) )
            return (new WineController)->loadWineComments($wineId);

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
                            ->paginate(10);

        return response()->json($comments, 200);
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
                            ->paginate(10);

        return response()->json($comments, 200);
    }

}
