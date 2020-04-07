<?php

namespace App\Http\Controllers;

use App\Article;

use App\Happening;

use App\Wine;

use App\Winery;

use App\User;

use App\Favourite;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function loadNewsList(Request $r) {
        $languageId = $r->header('Accept-Language');

        $json = Article::list($languageId, 'asc', true)->get();//->toBase()->merge( Happening::list($languageId, 'asc', true)->get()->toBase() );
        $json = $json->sortByDesc('created_at')->values();

        $paginated = $json->paginate(10);
        $paginated->setPath('feed/news');

        $languageId = $r->header('Accept-Language');
        $paginated->getCollection()->transliterate($languageId);

        return response()->json($paginated, 200);
    }

    public function loadSingleNews(Request $r, $id) {
      $langId= $r->header('Accept-Language', 1);

      $single_instance= Article::list($langId, 'asc', true)->where('articles.id',$id)->first();
      if(empty($single_instance))
        return response()->json(['message'=> 'not found'], 404);
      else return response()->json($single_instance);
    }

    public function loadRecommendations(Request $r) {
        $languageId = $r->header('Accept-Language');

        // app('db')->enableQueryLog();

        $wines = Wine::list($languageId, 'asc', true)->where('wines.recommended', 1)->get();

        // dd( app('db')->getQueryLog() );

        $wineries = Winery::list($languageId, 'asc', true)->where('recommended', 1)->get();

        $json = $wines->toBase()->merge( $wineries->toBase() );
        $json = $json->sortByDesc('highlighted')->values();

        $paginated = $json->paginate(10);
        $paginated->setPath('feed/recommended');

        return response()->json($paginated, 200);
    }

    public function loadFavourites(Request $r) {
        $languageId = $r->header('Accept-Language');

        $wines = Wine::list($languageId, 'asc', true)->whereIn('wines.id', $r->wines)->get();
        $wineries = Winery::list($languageId, 'asc', true)->whereIn('wineries.id', $r->wineries)->get();
//        \Log::info('request favourites',$r->all());
        $json = $wines->toBase()->merge( $wineries->toBase() );
        $json = $json->sortBy('name')->values();

        $paginated = $json->paginate(10);
        $paginated->setPath('feed/favourites');

        return response()->json($paginated, 200);
    }

    public function loadFavouritesForAuthenticated(Request $r) {
        $languageId = $r->header('Accept-Language');
        $social = User::find( app('auth')->user()->id );
        if (!$social)
            return response()->json(['error' => 'Invalid request'], 422);

        $favouriteIds = $social->favourites()->select('object_id', 'object_type')->get();
        $wineIds = $favouriteIds->where( 'object_type', app('\App\Wine')->flag )->pluck('object_id')->values();
        $wineryIds = $favouriteIds->where( 'object_type', app('\App\Winery')->flag )->pluck('object_id')->values();

        $wines = Wine::list($languageId, 'asc', true)->whereIn('wines.id', $wineIds)->get();
        $wineries = Winery::list($languageId, 'asc', true)->whereIn('wineries.id', $wineryIds)->get();

        $json = $wines->toBase()->merge( $wineries->toBase() );
        $json = $json->sortBy('name')->values();

        $paginated = $json->paginate(10);
        $paginated->setPath('feed/favourites/auth');

        return response()->json($json, 200);
    }

    public function addFavourite(Request $req) {
        if ( !$req->has(['object_type', 'object_id']) )
            return response()->json(['error' => 'Incomplete request'], 422);

        $data = $req->only(['object_type', 'object_id']);
        $data['social_id'] = app('auth')->user()->id;
        $favourite = Favourite::create($data);

        if (!$favourite)
            return response()->json(['error' => 'Something went wrong'], 500);

        return response(null, 204);
    }

    public function removeFavourite(Request $req) {
        \Log::info('remove vino', $req->all());
        if ( !$req->has(['object_id', 'object_type']) )
            return response()->json(['error' => 'Incomplete request'], 422);

        $constraints = $req->only(['object_id', 'object_type']);
        $constraints['social_id'] = app('auth')->user()->id;

        if ( !Favourite::where($constraints)->delete() )
            return response()->json(['outcome' => 'No favourites found'], 200);

        return response(null, 204);
    }

    public function adminHomepage() {
        $wines = Wine::count();
        $wineries = Winery::count();
        $events = Happening::count();
        $articles = Article::count();
        $users = User::count();
        return response()->json(compact(
            'wines', 'wineries', 'events', 'articles', 'users'
        ), 200);
    }

}
