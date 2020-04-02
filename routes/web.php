<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('migrate_refresh', function () {
//     \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

//     $tables = app('db')->select('SHOW TABLES');
//     foreach ($tables as $tableRow) {
//         $table = $tableRow->Tables_in_predrag_vv;
//         echo "Deleting table {$table} <br>";
//         app('db')->statement("DROP TABLE {$table}");
//     }

//     echo "<br><br><br>";

//     \Illuminate\Support\Facades\Artisan::call('migrate');

//     $output = str_replace(
//     	"\n",
//     	"<br>",
//         \Illuminate\Support\Facades\Artisan::output()
//     );

//     print_r($output);

//     echo "<br><br><br>";

//     \Illuminate\Support\Facades\Artisan::call('db:seed');

//     \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

//     $output = str_replace(
//         "\n",
//         "<br>",
//         \Illuminate\Support\Facades\Artisan::output()
//     );

//     print_r($output);
// });

// $router->get('test', 'BaseController@test');

$router->post('dump', 'BaseController@dump');

$router->get('mobile/sync', 'BaseController@syncWithMobile');


$router->post('login', 'AuthenticateController@login');

$router->post('/',function(){
    return response()->json(['message'=>'Not found page'],200);
});
$router->group(['middleware' => 'auth'], function() use ($router) {


	$router->post('/add/language/field', function(\Illuminate\Http\Request $request) {
		$lang = \App\Language::findOrFail($request->language_id);
		$field = \App\TextField::create([
			'name' => $request->name,
			'value' => $request->value,
			'language_id' => $lang->id,
			'object_id' => $lang->id,
			'object_type' => $request->object_type
		]);

		return $field;
	});

	//		-- Feed --

	$router->post('feed/favourites/auth', 'FeedController@loadFavouritesForAuthenticated');

	$router->post('favourites/add', 'FeedController@addFavourite');



	//		-- CRUD --

	$router->post('create/{resource}', 'BaseController@create');



	//		-- Winery --

	$router->get('my/wineries', 'WineryController@userWinery');

	$router->get('my/wines', 'WineController@userWines');

	$router->get('my/wineries/dropdown', 'WineryController@userWineryDropdown');

	$router->get('my/wines/dropdown', 'WineController@userWinesDropdown');

    $router->post('my/winery/filter', 'WineryController@filterUserWineries');


});



$router->group(['middleware' => 'mobileAuth'], function() use ($router) {



	//		-- Rates --

	$router->get('winery/comments/{wineryId}/mobile', 'SocialController@wineryComments');

    $router->get('winery/comments','SocialController@wineryCommentsAll');

	$router->get('wine/comments/{wineId}/mobile', 'SocialController@wineComments');

	$router->get('wine/comments','SocialController@wineCommentsAll');


});

$router->get('wine/filter/initialize/mobile', 'WineController@initalizeFilterMobile');

$router->get('winery/filter/initialize/mobile', 'WineryController@initializeFilterMobile');

//		-- Rates --

$router->get('rate/approve/{id}', 'SocialController@approveComment');

$router->get('rate/deapprove/{id}', 'SocialController@deapproveComment');

// $router->get('/')

$router->get('{object}/{id}/rate/{type}', 'RateController@filter');



//		-- Feed --

$router->get('feed/news', 'FeedController@loadNewsList');

$router->get('feed/recommended/', 'FeedController@loadRecommendations');

$router->post('feed/favourites', 'FeedController@loadFavourites');

$router->post('favourites/remove', 'FeedController@removeFavourite');

$router->get('feed/homepage', 'FeedController@adminHomepage');



//		-- Event --

$router->get('event/month/{year}/{month}', 'EventController@eventsInMonth');



//		-- Image --

$router->get('cover/{object}/{id}/{antiCache}', ['uses' => 'ImageController@loadCover', 'as' => 'cover_image']);

$router->get('logo/{object}/{id}/{antiCache}', ['uses' => 'ImageController@loadLogo', 'as' => 'logo_image']);

$router->get('bottle/{id}/{antiCache}', ['uses' => 'ImageController@loadBottleImage', 'as' => 'bottle_image']);



//		-- Wine --

$router->get('mobile/get/wine', 'WineController@loadWinesForMobile');

$router->get('wine/category/{categoryId}', 'WineController@categoryWines');

$router->get('wine/winery/{wineryId}/{categoryId}', 'WineController@wineryWines');

$router->get('wine/comments/panel', 'WineController@loadAllWineComments');

// $router->get('wine/comments/panel/foradmin', 'WineController@loadAllWineCommentsForAdmin');

$router->get('wine/comments/{wineId}', 'WineController@loadWineComments');

$router->get('wine/comments/{wineId}/admin', 'WineController@loadWineCommentsForAdmin');

$router->get('wine/filter/initialize', 'WineController@initializeFilter');

$router->post('wine/filter', 'WineController@filter');

$router->post('wine/filter/nopagination', 'WineController@filterWithoutPagination');

$router->get('wine/searched', 'WineController@searchedForWines');

$router->get('wine/highlighted', 'WineController@getHighlighted');

$router->get('get/category/paginate', 'WineController@paginateAllCategories');



//		-- Winery --


$router->get('winery/comments/panel', 'WineryController@loadAllWineryComments');

// $router->get('winery/comments/panel/admin', 'WineryController@loadAllWineryCommentsForAdmin');

$router->get('winery/comments/{wineryId}', 'WineryController@loadWineryComments');

$router->get('winery/comments/all/admin', 'WineryController@loadAllWineryCommentsForAdmin');

$router->get('winery/comments/{wineId}/admin', 'WineryController@loadWineryCommentsForAdmin');

$router->get('winery/video/{wineryId}', 'WineryController@loadVideo');

$router->get('winery/filter/initialize', 'WineryController@initializeFilter');

$router->post('winery/filter', 'WineryController@filter');

$router->post('winery/filter/nopagination', 'WineryController@filterWithoutPagination');

$router->get('winery/searched', 'WineryController@searchedForWineries');

$router->get('get/winery/nopagination', 'WineryController@ovoJeSamoZaAcu'); // Za Acu

$router->get('get/winery/all','WineryController@loadAllWinaries');

	// -- Gallery --

$router->get('gallery/{wineryId}/get', 'GalleryController@getGallery');

$router->get('gallery/{wineryId}/get/{id}', ['uses' => 'GalleryController@getImage', 'as' => 'gallery_image']);

$router->post('gallery/{wineryId}/add', 'GalleryController@addImage');

$router->get('gallery/{wineryId}/remove/{id}', 'GalleryController@removeFileFromGallery');

$router->get('gallery/{wineryId}/reposition/{fileId}/{newPosition}', 'GalleryController@repositionFileInGallery');



//		-- Area --

$router->get('area/children/{areaId}', 'AreaController@loadWithChildren');

$router->get('area/{type}', 'AreaController@filterByType');

$router->get('area/dropdown/nested', 'AreaController@nestedDropdown');

$router->get('area/dropdown/{type}', 'AreaController@areaDropdown');



//		-- CRUD --

$router->get('get/{resource}', 'BaseController@loadAll');

$router->get('get/{resource}/paginate', 'BaseController@loadWithPagination');

$router->get('get/{resource}/{id}', 'BaseController@loadSingle'); //$router->get('get/{resource}/{id}/{languageId}', 'BaseController@loadSingle');

$router->get('patch/initialize/{resource}/{id}', 'BaseController@patchInitialize');

$router->post('patch/{resource}/{id}', 'BaseController@patch');

$router->delete('delete/{resource}/{id}', 'BaseController@delete');

//$router->post('user/password/change/{id}', 'UserController@patchPassword');

	// -- Language --

$router->delete('delete/language/{resource}/{resourceId}/{languageId}', 'BaseController@deleteResourceLanguage');

$router->post('add/language/{resource}/{resourceId}', 'BaseController@addLanguageToResource');

	// -- Miscellaneous --

$router->get('search/{resource}', 'BaseController@loadPois');
$router->post('search/{resource}', 'BaseController@search');

$router->get('dropdown/{resource}', 'BaseController@dropdown');



//		-- Language --

$router->get('mobile/language/{socialId}', 'LanguageController@loadForMobile');

$router->get('web/language', 'LanguageController@loadForWeb');

$router->delete('language/delete/{resource}/{resourceId}/{languageId}', 'LanguageController@deleteLanguageFromResource');



//		-- Social --

$router->post('social/register', 'UserController@register');

$router->post('social/register/google', 'SocialController@registerWithGoogle');

$router->get('social/image/{id}', ['uses' => 'SocialController@loadUserImage', 'as' => 'profile_pic']);

$router->get('user/{type}/dropdown', 'UserController@filterUsersDropdown');

$router->get('user/{type}','UserController@filterUsers');

$router->get('user/{type}/{order}', 'UserController@filterUsers');





//		-- POI --

$router->get('poi/get/paginate', 'PaginationController@paginatePois');



//		-- Push notifications --

$router->post('push/send', 'SocialController@notifyUsers');

$router->post('push/critical', 'SocialController@criticalNotification');



//		-- Wine route --

$router->post('route/auto', 'PathController@generatePath');

$router->post('poi/range', 'PathController@inRange');


//      --StartScreen(Ads) route--

$router->post('startScreen/create','AdvertisingController@store');

$router->get('startScreen/all','AdvertisingController@all');

$router->post('startScreen/patch/{id}','AdvertisingController@patchAds');

$router->get('startScreen/all/mobile','AdvertisingController@patchAdsMobile');

$router->get('startScreen/{section}','AdvertisingController@loadBySection');

$router->get('startScreen/{section}/mobile','AdvertisingController@loadBySection');

$router->delete('startScreen/delete/{id}','AdvertisingController@deleteAds');

$router->get('startScreen/image/{id}','ImageController@loadAdImage');


//      --Wine recommended/highlighted route--

$router->post('highlight/createOrPatch','HighlightController@change');

$router->post('highlight/view','HighlightController@show');

//$router->get('highlight/test','HighlightController@insertNeccessaryData');

$router->get('highlight/all','HighlightController@all');

//      --Settings route--
$router->post('settings/createOrPatch','SettingsController@makeOrEdit');

$router->get('getSettingGoogle','SettingsController@getAll');

$router->get('testStorage', 'TestController@testDB');

$router->get('getUserByType/{userType}','TestController@loadByType');

// $router->get('log/download', 'TestController@logDownload');
// $router->get('test','TestController@index');
// $router->post('testImage','TestController@saveImage');
// $router->get('insertTextFields','TestController@textFieldsInsert');
// $router->get('textSeeder', 'TestController@textFieldsSeeder');
// $router->get('insertTable', 'TestController@insertTable');
// $router->get('consoleCheck', 'TestController@consoleindex');
// $router->get('pathCheck', 'TestController@checkPath');
// $router->get('remove/duplicates', 'TestController@removeDuplicates');
// $router->get('carbon/check', 'TestController@carbonCheck');
