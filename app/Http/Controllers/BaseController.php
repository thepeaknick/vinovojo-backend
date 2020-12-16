<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use stdClass;

class BaseController extends Controller
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

    private function resourceClass($resource)
    {
        return '\App\\' . ucfirst($resource);
    }

    //      -- Create --
    
    /**
     * Method create
     *
     * @param Request $r [explicite description]
     * @param string $resource [\App\Model::class]
     *
     * Create for every instance Model in App
     * Resource can be every model to lower case eg. user,wine/winery...
     * @return void
     */
    public function create(Request $r, $resource)
    {
        if ($r->has('json')) {
            $r->replace(json_decode($r->json, 1));
        }

        \Log::info('Zahtev za create ' . $resource, $r->all());

        $model = $this->resourceClass($resource);
        $instance = new $model;

        if (!$instance->preCreate($r)) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        if ($instance->validatesBeforeCreation()) {
            $this->validate($r, $instance->getRules());
        }

        $instance->fill($r->except(['languages', 'point']));
        if (!$instance->save()) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        if ($r->has('languages')) {
            if (!$instance->saveLanguages($r->languages)) {
                return response()->json(['error' => 'Resource saved but transliteration failed', 500]);
            }
        }

        if (!$instance->postCreation($r)) {
            return response()->json(['error' => $resource . ' saved but not fully proccesed'], 202);
        }

        if($model=='\App\Winery' || $model=='Winery')
            return response()->json(['message'=>'success','winery'=>$instance]);

        return response()->json(['message' => 'Created ' . $resource], 201);
    }

    //      -- Read --
    
    /**
     * Method loadAll
     *
     * @param string $resource ['wine', 'winery', ...]
     * @param Request $r [explicite description]
     *
     * Read every resource depends on param
     * @return void
     */
    public function loadAll($resource, Request $r)
    {

        $result = WineType::get();
        //  $sorting = $r->header('Sorting', 'asc');
        $languageId = $r->header('Accept-Language');

		$model = $this->resourceClass($resource);
		$instances=[];
		$sorting = $r->header('Sorting', 'asc');
		$sortBy = '';
        if ($r->header('Sort-By')) {
            $sortBy = $r->header('Sort-By');
        }
		switch ($model) 
		{
            case '\App\Wine':
			{
				$search= '';
				if ($r->has('search')) 
					$search= $r->search;
                $instances = $model::list($languageId, $sorting, true, $search, $sortBy);
                return $instances->paginate(10);
			break;
			};
            case '\App\Winery':
			{
				$search= '';
                $search= (!$r->has('search'))?'':$r->search;
                $instances = $model::list($languageId, $sorting, true, $search, $sortBy);
                return $instances->paginate(10);
				break;
			};
            case '\App\Article':
			{
				
				break;
			};
			case '\App\User':
			{
                $search= (!$r->has('search'))?'':$r->search;
				$instances = $model::listWithSearch($languageId, $sorting, false, $search, $sortBy);
				break;
			}
			case '\App\Happening':
            {
                $sorting = $r->header('Sorting', 'desc');
                $search= (!$r->has('search'))?'':$r->search;
                $instances = $model::list($languageId, $sorting, true, $search, $sortBy);
                return $instances->get();
            break;
            }			
            case '\App\WinePath':
                {
                    $instances = $model::list($languageId, $sorting, true);
                    return $instances->paginate(50);
                    break;	
                }
                case '\App\Category':			
                case '\App\PointOfInterest':
			{
                $search= (!$r->has('search'))?'':$r->search;
                $instances = $model::list($languageId, $sorting, true, $search, $sortBy);
                return $instances->get(10);
				break;
			}
            default:
			{
                $search= (!$r->has('search'))?'':$r->search;
				$instances= $model::list($languageId, $sorting, true, $search, $sortBy);
				return $instances->get();
				break;
			};
			return $instances;
        }
        if ($model == '\App\Happening') {
            $sorting = $r->header('Sorting', 'desc');
        } else {
            $sorting = $r->header('Sorting', 'asc');
        }

        $sortBy = '';
        if ($r->header('Sort-By')) {
            $sortBy = $r->header('Sort-By');
        }
        if ($r->has('search')) {
            $search = $r->search;
            if ($model == '\App\Wine' || $model == '\App\Winery') {
                $instances = $model::listWithLiked($languageId, $sorting, false, $search, $sortBy);
            } else if ($model == '\App\User') {
                $instances = $model::listWithSearch($languageId, $sorting, false, $search, $sortBy);
                return $instances;
            } else {
                if ($model == '\App\WinePath') {
                    $instances = $model::list($languageId, $sorting, true);
                } else {
                    $instances = $model::list($languageId, $sorting, false, $search, $sortBy);
                    if ($model == '\App\Article') {
                        return $instances;
                    }

                }
            }

        } else {
            $search = '';
            if ($model == '\App\Wine' || $model == '\App\Winery') {
                $instances = $model::listWithLiked($languageId, $sorting, false, $search, $sortBy);
                return response()->json($instances->paginate(12));
            } else if ($model == '\App\User') {
                $instances = $model::listWithSearch($languageId, $sorting, false, $search, $sortBy);
                return $instances;
            } else {
                if ($model == '\App\WinePath') {
                    $instances = $model::list($languageId, $sorting, true);
                } else if ($model == '\App\PointOfInterest') {
                    $instances = $model::list($languageId, $sorting);
                    return response()->json($instances);
                } else {
                    $instances = $model::list($languageId, $sorting, true, $search, $sortBy);
                }
            }

        }
        if ($model == '\App\Category' || $model == '\App\PointOfInterest') {
            return $instances->get();
        }

//        Manually sort  rates
        if ($model == '\App\Wine' || $model == '\App\Winery') {
            foreach ($instances as $instance) {
                if (isset(((object) $instance)->rate_count)) {
                    $count = \App\Rate::where('object_id', $instance['id'])->where('rates.status', '=', 'approved')->whereNotNull('rates.rate')->get()->count();
                    $instance['rate_count'] = $count;
                }
            }
            return $instances;
        }

        if ($resource == 'winePath' || $model == '\App\WinePath') {
            return $instances->paginate(50);
        }

        if ($instances instanceof Illuminate\Database\Eloquent\Builder) {
            return $instances->get()->paginate(10);
        }

        return $instances->get();
    }
    
    /**
     * Method loadWithPagination
     *
     * @param $resource $resource ['wine', 'winery'...]
     * @param Request $r [explicite description]
     *
     * Load Every resource depends on URL with pagination
     * @return json
     */
    public function loadWithPagination($resource, Request $r)
    {
        $sorting = $r->header('Sorting');
        $sorting = (is_null($sorting)) ? 'asc' : $sorting;

        $languageId = $r->header('Accept-Language');

        $model = $this->resourceClass($resource);

        if ($r->has('search')) {
            $search = $r->search;
        } else {
            $search = '';
        }
        if ($resource == 'winery') {
            $instances = $model::list($languageId, $sorting, true, $search);
            foreach ($instances as $winery) {

            }
        }
        if ($resource == 'wineClass') {
            return $model::list($languageId, $sorting, true, $search)->paginate(50);
        }
        return $model::list($languageId, $sorting, true, $search)->paginate(10);
    }

    public function loadSingle($resource, $id, Request $r)
    {
        $languageId = $r->header('Accept-Language');

        $model = $this->resourceClass($resource);
        $instance = $model::find($id);
        if (!$instance) {
            return response()->json(['error' => $resource . ' not found'], 404);
        }

        if (!is_null($languageId)) {
            $instance->transliterate($languageId);
        }

        return $instance->singleDisplay($languageId);
    }

    //      -- Update --

    public function patchInitialize($resource, $id)
    {
        $area = \App\Area::dropdown(1);
        $model = $this->resourceClass($resource);
        $instance = $model::find($id);

        if ($resource == 'area' && $instance) {
            $instance = $instance->list(1, 'asc', true)
                ->where('areas.id', $instance->id)
                ->first();
            return $instance->patchInitialize();
        }
        $return = $instance->patchInitialize();


        if (!$instance) {
            return response()->json(['error' => ucfirst($resource) . ' not found'], 404);
        }

        return $instance->patchInitialize();
    }
    
    /**
     * Method patch
     *
     * @param Request $r
     * @param $resource $resource ['wine', 'winery',...]
     * @param $id $id [Model id]
     *
     * Patch/Update single model depend on URL
     * URL example: "/patch/user/1"
     * @return void
     */
    public function patch(Request $r, $resource, $id)
    {
        $model = $this->resourceClass($resource);
        \Log::info('Zahtev za patch ' . $resource, $r->all());
        if ($r->has('json')) {
            $r->replace(json_decode($r->json, 1));
        }

        $instance = $model::find($id);
        if (!$instance) {
            return response()->json(['error' => $resource . ' not found'], 404);
        }

        if ($instance->validatesBeforeUpdate() && !($instance instanceof \App\User)) {
            $this->validate($r, $instance->rules);
        }

        if ($instance instanceof \App\User) {
            if ($r->has('profile_picture')) {
                $instance->saveProfile($r->profile_picture);
            }
        }

        if ($instance->update($r)) {
            return response()->json(['message' => 'Updated succefully'], 203);
        }

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    //      -- Delete --

    public function delete($resource, $id)
    {
        $model = $this->resourceClass($resource);

        $instance = $model::find($id);
        if (!$instance) {
            return response()->json(['error' => $resource . ' not found'], 404);
        }

        if ($model == '\App\User') {
            if (!$instance->clear()) {
                return response()->json(['message' => 'Something went wrong'], 500);
            }

        } else {
            try {
                $instance->delete();
            } catch (\Illuminate\Database\QueryException $e) {
                $code = $e->errorInfo[1];
                if ($code == 1451) {
                    return response()->json(['error' => 'Constraint failed'], 409);
                }

                return response()->json(['error' => 'Something went wrong'], 500);
            }
        }

        return response(null, 204);
    }

    //      -- Language --

    public function addLanguageToResource(Request $r, $resource, $resourceId)
    {
        $model = $this->resourceClass($resource);

        $instance = $model::find($resourceId);
        if (!$instance) {
            return response()->json(['error' => $resource . ' not found'], 404);
        }

        if (!$r->has('languages')) {
            return response()->json(['error' => 'Invalid request'], 405);
        }

        if (!$instance->saveLanguages($r->languages)) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response(null, 204);
    }

    public function deleteResourceLanguage($resource, $resourceId, $languageId)
    {
        $model = $this->resourceClass($resource);

        $instance = $model::find($resourceId);

        if (!$instance) {
            return response()->json(['error' => $resource . ' not found'], 404);
        }

        if (!$instance->deleteLanguage($languageId)) {
            return response()->json(['error' => 'There was an error'], 500);
        }

        return response(null, 204);
    }

    //      -- Custom --

    public function search($resource, Request $req)
    {
        $languageId = $req->header('Accept-Language');
        $model = $this->resourceClass($resource);
        $results = $model::search($req->search, $languageId);
        return response()->json($results, 200);
    }

    public function searchByParam($resource, Request $req)
    {
        $model = $this->resourceClass($resource);
        $langId = ($req->header('Accept-Language')) ? $req->header('Accept-Language') : 1;
        $model = $this->resourceClass($resource);
        $match = new stdClass();
        $match->name = strtolower($req->name);
        $match->value = strtolower($req->value);
        return $model::loadByParam($match, $langId);
    }

    public function dropdown(Request $req, $resource)
    {
        $model = $this->resourceClass($resource);

        $languageId = $req->header('Accept-Language');
        return $model::dropdown($languageId);
    }

    public function syncWithMobile(Request $req)
    {
        $languageId = $req->header('Accept-Language');
        $data['wineries'] = \App\Winery::all();
        $data['wines'] = \App\Wine::all();
        $data['pois'] = \App\PointOfInterest::all();
        foreach ($data as $collection) {
            $collection->transform(function ($instance) use ($languageId) {
                return $instance->singleDisplay($languageId);
            });
        }
        return $data;
    }

    public function removeFavourite($id, $flag)
    {
        $favourite = \App\Favourite::where('object_id', '=', $id)->where('object_type', '=', $flag)->first();
        if ($favourite !== null && $favourite->delete()) {
            return response()->json(['message' => 'successifully deleted'], 204);
        }

        return response()->json(['message' => 'not found'], 404);
    }

    public function test()
    {

        return \Illuminate\Support\Facades\Artisan::call('migrate:refresh', ['--seed' => true]);

        $lang = json_decode($this->rsJson, 1);
        $array = array_keys($lang);

        foreach ($array as $key) {
            echo "'" . $key . "' => 'required|string',<br>";
        }
        return;

        return \App\Winery::first()->gallery;
        $s = \App\Social::first();
        dd(Socialite::driver('facebook')->userFromToken($s->social_key));
    }

        
    /**
     * rsJson
     *
     * Resources for static strings
     * This is fallback, if not exists in database
     * @var string
     */
    private $rsJson = '{

	"app_name": "Vinovojo",

	"internet_problem": "Problem sa internet konekcijom…",

	"connect": "Konektuj se",

	"no": "Ne",

	"error_load_date": "Molimo Vas učitajte ponovo.",

	"error_load_marker_on_map": "Došlo je do greške, mapa nije u potpunosti učitana, pokušajte kasnije.",

	"error_no_item_in_wishList": "Trenutno nemate sačuvane vinarije ili vina.",

	"wishList_wine_message_save": "Sačuvali ste ovo vino u listi omiljenih stavki.",

	"wishList_wine_message_un_save": "Obrisali ste ovo vino iz listi omiljenih stavki.",

	"wishList_winery_message_save": "Sačuvali ste ovu vinariju u listi omiljenih.",

	"wishList_winery_message_un_save": "Obrisali ste ovu vinariju iz liste omiljenih.",

	"news_fragment_secondary_tab_1": "Vesti",

	"news_fragment_secondary_tab_2": "Preporučeno",

	"news_fragment_secondary_tab_3": "Omiljeno",

	"wine_main_fragment_secondary_tab_1": "Vinarije",

	"wine_main_fragment_secondary_tab_2": "Vina",

	"search_winery": "Pretraži vinarije",

	"search_wine": "Pretraži vina",

	"wine_clear_filter": "Filter je poništen",

	"events_fragment_save_events_in_calendar": "Sačuvali ste ovaj događaj u svom kalendaru.",

	"error_login": "Doslo je do greske, prilikom povezivanja.",

	"activity_login_screen_message": "Da biste koristili sve funkcije aplikacije,\\n morate biti ulogovani.",

	"activity_login_with_instagram": "Uloguj se Instagram nalogom",

	"activity_login_with_google": "Uloguj se Google+ nalogom",

	"activity_login_with_facebook": "Uloguj se Facebook nalogom",

	"activity_login_text_logout": "Odjavi se",

	"title_activity_settings": "Settings",

	"fragment_map_open_all_marker": "Tačke od interesta.",

	"fragment_map_open_all_region": "Vinske Regije",

	"error_no_network_connection": "Došlo je do greške, proverite internet konekciju.",

	"activity_comment_add_comment": "DODAJ KOMENTAR",

	"activity_comment_placeholder_comment": "Pipnite ovde da biste počeli sa pisanjem komentara.Možete napisati sve što mislite o ovom vinu u najviše500 karaktera.",

	"activity_comment_success_add_comment": "Uspešno ste dodali komentar",

	"profile_menu_toogle_yes": "Da",

	"profile_menu_toogle_no": "Ne",

	"activity_login_success_login": "Uspesno ste ulogovani",

	"activity_login_success_logout": "Uspesno ste izlogovani.",

	"working_time_default": "Ne radi",

	"activity_winery_details_region": "Region",

	"fragment_wine_road_toolbar_title": "Vinski putevi",

	"activity_comment_tollbar_title": "Komentar za",

	"activity_comment_text_rate_wine": "Oceni ovo vino",

	"activity_comment_text_add_comment": "Napisi komentar",

	"activity_comment_text_rate_winery": "Oceni ovu vinariju",

	"activity_comment_text_alert_menu_choose_option_photo": "Izaberi opciju",

	"activity_comment_text_alert_menu_choose_option_photo_message": "Kako želite da postavite sliku?",

	"activity_comment_text_alert_menu_choose_option_photo_gallery": "Galerija",

	"activity_comment_text_alert_menu_choose_option_camera": "Kamera",

	"text_share_title": "Share via",

	"activity_login_tour_guide_step_1_title": "Prijava",

	"activity_login_tour_guide_step_1_message": "Prijavi se ili registruj preko Vinovojo platforme.",

	"activity_login_tour_guide_step_2_title": "Prijava",

	"activity_login_tour_guide_step_2_message": "Mozda i preko neke drustvene mreze.",

	"activity_login_email_invalid_credentials": "Invalid Credentials.",

	"activity_main_side_menu_option_1_language": "Jezik",

	"activity_main_side_menu_option_2_notification": "Notification",

	"activity_main_side_menu_option_3_add_your_wine_path": "Dodajte vašu rutu",

	"activity_main_side_menu_option_4_favorites": "Omiljene stavke",

	"activity_register_alert_toast_message_all_fields_required": "Morate popuniti sva polja.",

	"activity_register_alert_toast_message_phone_field_is_required": "Broj telfona je obavezan.",

	"activity_register_hint_enter_name": "Unesite Ime",

	"activity_register_label_name": "Ime:",

	"activity_register_hint_enter_lastname": "Unesite Prezime",

	"activity_register_label_lastname": "Prezime:",

	"activity_register_next_step": "Nastavi",

	"activity_register_hint_enter_phone": "Unesite br telefona",

	"activity_register_label_phone": "Broj telefona:",

	"activity_register_hint_enter_email": "Unesite email adresu",

	"activity_register_label_email": "Email:",

	"activity_register_hint_enter_password": "Unesite lozinku",

	"activity_register_label_password": "Lozinka:",

	"activity_register_final_step_register": "Registruj se",

	"activity_search_last_seachhing": "Poslednje Pretrage",

	"activity_search_last_popular": "Popularne Pretrage",

	"activity_wine_details_rating_single": "ocena",

	"activity_wine_details_rating_multyple": "ocene",

	"activity_wine_details_share_message": "Detalje o ovom vinu i još drugim vinima i vinarijama možete pogledati u aplikaciji Vinovojo",

	"activity_wine_details_tour_guide_step_1_title": "Vinarija",

	"activity_wine_details_tour_guide_step_1_message": "Vidi detalje o Vinariji.",

	"activity_wine_details_tour_guide_step_3_title": "Komentar",

	"activity_wine_details_tour_guide_step_3_message": "Dodaj komentar za ovo vino, napisi svoj utisak, i oceni.",

	"activity_wine_details_tour_guide_step_4_title": "Podeli Vino",

	"activity_wine_details_tour_guide_step_4_message": "Podeli vino na drustvenim mrezama, ili nekom prijatelju.",

	"activity_wine_details_tour_guide_step_5_title": "Omiljeno Vino",

	"activity_wine_details_tour_guide_step_5_message": "Dodaj vino u listu svojih omiljenih vina.",

	"activity_winery_details_tour_guide_step_1_title": "Lokacija Vinarije",

	"activity_winery_details_tour_guide_step_1_message": "Prikazuje se vinarija na mapi",

	"activity_winery_details_tour_guide_step_2_title": "Kontakt",

	"activity_winery_details_tour_guide_step_2_message": "Klikni i zakazi posetu vinariji.",

	"activity_winery_details_tour_guide_step_3_title": "Promotivni video",

	"activity_winery_details_tour_guide_step_3_message": "Pogledaj promotivni video klip vinarije.",

	"activity_winery_details_tour_guide_step_4_title": "Komentar",

	"activity_winery_details_tour_guide_step_4_message": "Dodaj komentar za ovu vinariju, napisi svoj utisak, i oceni.",

	"activity_winery_details_tour_guide_step_5_title": "Podeli Vinariju",

	"activity_winery_details_tour_guide_step_5_message": "Podeli vinariju na drustvenim mrezama, ili nekom prijatelju.",

	"activity_winery_details_tour_guide_step_6_title": "Omiljene Vinarije",

	"activity_winery_details_tour_guide_step_6_message": "Dodaj vinariju u listu svojih omiljenih vinarija.",

	"wine_view_holder_card_harvast": "Berba",

	"activity_language_list_title_toolbar": "Odabir jezika",

	"activity_login_with_vinovojo": "Uloguj se Vinovojo nalogom",

	"activity_login_email_label_email": "Email:",

	"activity_login_email_label_password": "Password:",

	"activity_login_email_hint_email": "Enter email",

	"activity_login_email_hint_password": "Enter password",

	"activity_login_email_button_login": "Login",

	"activity_login_email_button_register": "Kreiraj nalog",

	"activity_register_textView_profile_image": "Profilna slika",

	"activity_register_button_register": "Registruj se",

	"alert_dialog_exit_message": "Izlazite iz apllikacije?",

	"alert_dialog_exit_negativ_answer": "NE",

	"alert_dialog_exit_positiv_answer": "DA",

	"activity_spalsh_message_first_notification": "Dobro došli, nadamo se da će vam se svideti naša aplikacija.  Vinovojo tim.",

	"activity_wine_details_about_wine": "O vinu",

	"activity_wine_details_last_comments": "Poslednji komentari",

	"activity_wine_details_all_comments": "Svi komentari",

	"activity_wine_details_add_new_comment": "Dodaj komentar",

	"activity_wine_details_share_wine": "PODELI VINO",

	"activity_wine_details_comment_rate": "KOMENTAR / OCENA",

	"activity_wine_details_add_wish_list": "SAČUVAJ VINO",

	"activity_wine_details_attributes_type_wine": "Vrsta vina",

	"activity_wine_details_attributes_sort_wine": "Grožđe (Sorta)",

	"activity_wine_details_attributes_alcohol": "Alkohol",

	"activity_wine_details_attributes_harvest": "Berba",

	"activity_wine_details_attributes_declaration": "Deklaracija Vina",

	"activity_winery_details_share_wine": "PODELI VINARIJU",

	"activity_winery_details_comment_rate": "KOMENTAR / OCENA",

	"activity_winery_details_add_wish_list": "SAČUVAJ VINARIJU",

	"activity_winery_details_add_new_comment": "Dodaj komentar",

	"activity_winery_details_all_comments": "Svi komentari",

	"activity_winery_details_last_comments": "Poslednji komentari",

	"activity_winery_details_rating_single": "ocena",

	"activity_winery_details_rating_multyple": "ocene",

	"activity_winery_details_web_site": "Web site:",

	"activity_winery_details_mob": "Mob:",

	"item_card_wine_tour_guide_wish_list_wine_title": "Omiljeno Vino",

	"item_card_wine_tour_guide_wish_list_wine_message": "Dodajte ovo vino u listu omiljenih vina i vinarija.",

	"item_card_wine_tour_guide_share_title": "Podeli vino sa prijateljima.",

	"item_card_wine_tour_guide_share_message": "Podeli ovo vino, nekom prijatelju, preko društvene mreže ili neke druge aplikacije.",

	"item_card_wine_tour_guide_comment_title": "Komentar",

	"item_card_wine_tour_guide_comment_message": "Ostavi komentar, za ovo vino. Podeli sa drugima tvoj utisak o ovom vinu, postavi sliku, i ocenu …",

	"item_card_wine_tour_guide_title_title": "Vino",

	"item_card_wine_tour_guide_title_message": "Otvori karticu, i vidi detaljnije opise ovog vina, poreklo, godina berbe, sorta, temperatura serviranja …",

	"item_card_winery_tour_guide_wish_list_title": "Omiljena Vinarija",

	"item_card_winery_tour_guide_wish_list_message": "Dodajte ovu vinariju u listu omiljenih vinarija i vina.",

	"item_card_winery_tour_guide_share_title": "Podeli vinariju sa prijateljima.",

	"item_card_winery_tour_guide_share_message": "Podeli ovu vinariju, nekom prijatelju, preko društvene mreže ili neke druge aplikacije.",

	"item_card_winery_tour_guide_comment_title": "Komentar",

	"item_card_winery_tour_guide_comment_message": "Ostavi komentar, za ovu vinariju. Podeli sa drugima tvoj utisak o ovoj vinariji, postavi sliku, i ocenu…",

	"item_card_winery_tour_guide_title_title": "Vinarija",

	"item_card_winery_tour_guide_title_message": "Otvori karticu, i vidi detaljnije opise ove vinarije, regiju vinarije, kontakt telefo, web sajt, promo video, galeriju slika,  …",

	"fragment_wine_main_tour_guide_search_title": "Pretraga",

	"fragment_wine_main_tour_guide_search_message": "Pretrazi vinarije ili vina.",

	"fragment_wine_main_tour_guide_tab_list_type_wine_title": "Lista sorti vina",

	"fragment_wine_main_tour_guide_tab_list_type_wine_message": "Otvori karticu sa nekom sortom, i prikazace se sva vina koja su napravljena od te sorte grozdja.",

	"fragment_wine_road_tour_guide_automatic_genrate_path_title": "Automatsko kreiranje puta",

	"fragment_wine_road_tour_guide_automatic_genrate_path_message": "Popunte manju formu, na osnovu tih podataka dobićete put, neki put.",

	"fragment_wine_road_tour_guide_go_direction_title": "Kreni u obilazak",

	"fragment_wine_road_tour_guide_go_direction_message": "Za rad ove aplikacije, potrebno je da na telefonu imate Google Maps aplikaciju. Klikom na ovo dugme, otvoriće se Google Maps aplikacija, i spremiće vam offline mapu koju možete da preuzmete i da obiđete ceo vinski put i bez internet konekekcije.",

	"fragment_wine_road_tour_guide_full_height_map_title": "Prikaži mapu u punoj veličini",

	"fragment_wine_road_tour_guide_full_height_map_message": "Klikom bilo gde na mapi, prikazuje se mapa na celom ekranu.",

	"fragment_news_feed_tour_guide_profile_title": "Profile",

	"fragment_news_feed_tour_guide_profile_message": "Za dodatne opcije, potrebno je da se prijavite.",

	"fragment_news_feed_tour_guide_recommended_title": "Preporucena Vina i Vinarije",

	"fragment_news_feed_tour_guide_recommended_message": "Za dodatne opcije, potrebno je da se prijavite.",

	"fragment_event_tour_guide_calendar_title": "Kalendar sa događajima.",

	"fragment_event_tour_guide_calendar_message": "Kalendar, sa indikacijom da li tog datuma postoji neki događaj, klikom na taj datum dobijate mogućnost upisa tog događaja u vaš privatni kalendar kao podsetnik.",

	"fragment_map_marker_not_loaded": "Markeri još uvek nisu učitani.",

	"fragment_wish_list_not_favourites": "Trenutno nemate omiljene objekata.",

	"activity_maps_info_message": "Kliknite na marker na mapi, kako biste dodali tačku u svom putu. Nakon izbora tačaka pritisnite dugme, kreiraj put",

	"activity_maps_textView_btn_preview_markers": "Prikaži Markere",

	"activity_maps_textView_btn_generate_path": "Kreiraj put",

	"dialog_wine_filter_winery_in_radius": "Vinarje u krugu od",

	"dialog_wine_filter_selected_all": "Sve",

	"dialog_wine_filter_sorted_none": "Bez Sortiranja",

	"dialog_wine_filter_sorted_ascending": "Rastuće",

	"dialog_wine_filter_sorted_descending": "Opadajuće",

	"dialog_wine_filter_button_apply": "Poništi",

	"dialog_wine_filter_button_reset": "Primeni",

	"dialog_wine_filter_rating_3_and_more": "Ocena 3.5 i više",

	"dialog_wine_filter_region": "Regioni",

	"dialog_wine_filter_type_wine": "Tip Vina",

	"dialog_wine_filter_sort_wine": "Sorta Vina",

	"dialog_wine_filter_harvest_year": "Godina berbe",

	"dialog_wine_filter_winery": "Vinarija",

	"dialog_wine_filter_alcohol": "Alkohol",

	"dialog_wine_filter_sort_with_rating": "Sortiraj po oceni",

	"SIDEBAR_ADVERTISING_TITLE" : "Marketing",

	"SIDEBAR_ADVERTISING_SUBMENU_1":"Marketing Reklame",

	"SIDEBAR_ADVERTISING_SUBMENU_2":"Marketing Vinarije",

	"SIDEBAR_ADVERTISING_SUBMENU_3":"Marketing Vina",

	"SIDEBAR_ADVERTISING_SUBMENU_4":"Google ad\'s",

	"ROLE_ADMIN":"admin",

	"ADVERTISING_ADD_EVENT":"Dodaj reklamu",

	"ADS_IMAGE":"Slika",

	"ADS_TITLE":"Naziv",

	"ADS_START_DATE":"Pocetak",

	"ADS_END_DATE":"Kraj",

	"ADS_ACTIVE":"Aktivna",

	"ADS_EDIT":"Uredi",

	"ADS_DELETE":"Obrisi",

	"ADS_SECTION":"Sekcija",

	"ADS_REPEATING":"Ponavljanje",

	"ADS_ADD_IMAGE":"Dodaj Sliku",

	"ADS_WINERY_NAME":"Vinarija",

	"ADS_WINERY_SEARCH":"Pretraga vinarija",

	"ADS_WINERY_LANGUAGE":"Izaberite jezik",

	"ADS_WINERY_NAME":"Ime",

	"ADS_WINERY_ADDRESS":"Adresa",

	"ADS_WINERY_REGION":"Regija",

	"ADS_WINERY_OPTIONS":"Opcije",

	"ADS_WINERY_RECOMMENDED":"Preporuceno",

	"ADS_WINERY_HIGHLIGHTED":"Istaknuto",

	"ADS_WINERY_NOT_RECOMMENDED":"Nije Preporuceno",

	"ADS_WINERY_NOT_HIGHLIGHTED":"Nije Istaknuto",

	"ADS_ELEMENTS_PER_PAGE":"Elemenata po stranici",

	"ADS_WINE_NAME":"Naziv",

	"ADS_WINE_SEARCH":"Pretraga vina",

	"ADS_WINE_LANGUAGE":"Izaberite jezik",

	"ADS_WINE_YEAR":"Godina berbe",

	"ADS_WINE_WINERY_NAME":"Ime vinarije",

	"ADS_WINE_OPTIONS":"Opcije",

	"ADS_GOOGLE":"Google ads",

	"CHANGE_PASSWORD_INPUT":"Promeni sifru",

	"TABLES_WINERY_SEARCH_FIELD_LABEL": "Pretraga vinarije",

	"TABLES_RESET_FIELDS_BTN_TEXT": "Resetuj polja",

	"TABLES_WINE_SEARCH_FIELD_LABEL": "Pretraga vina",

	"SIDEBAR_COMMENTS_SUBMENU_1": "Komentari vinarija",

	"SIDEBAR_COMMENTS_SUBMENU_2": "Komentari vina",

	"TABLES_USERS_SEARCH_FIELD_LABEL": "Pretraga korisnika",

	"TABLES_ARTICLE_SEARCH_FIELD_LABEL": "Pretraga vesti",

    "TABLES_EVENTS_SEARCH_FIELD_LABEL": "Pretraga dešavanja"
    
    "RATE_WINERY_TABLE_NAME": "Naziv vinarije"
    
    "RATE_WINE_TABLE_NAME": "Naziv vina" 


}';

    public function dump(Request $r)
    {
        \Log::info('Data: ' . print_r($r->all(), 1));
        dd($r->all());
    }

}
