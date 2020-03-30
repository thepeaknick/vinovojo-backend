<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = [
          [
            'name' => 'Srpski',
            'code' => 'sr'
          ],
          [
            'name' => 'English',
            'code' => 'uk'
          ],
          [
            'name' => 'Espanol',
            'code' => 'es'
          ]
        ];

        $lol = new \App\Language;
        $lol->mobile = json_decode($this->serbianJson, 1);
        $lol->web = json_decode($this->feJson, 1);

        foreach ($langs as $l) {
          $language = new \App\Language;
          $language->name = $l['name'];
          $language->code = $l['code'];
          $language->save();
            if ($language->id == 1)
                $language->postCreation($lol);
        }
    }

    private $serbianJson = '{

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

  "activity_register_success_register" : "Uspešno ste registrovani na VInovojo platformi",

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

  "fragment_news_feed_no_recommended" : "Trenutno nema preporucenih",

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
  "dialog_wine_filter_sort_with_rating": "Sortiraj po oceni"

}';

  private $feJson = '{
  "SIDEBAR_USER_SETTTINGS_TITLE": "Korisnička podešavanja",
  "SIDEBAR_USER_LOGOUT_TILE": "Odjavi se",
  "SIDEBAR_CONTROL_BOARD_TITLE": "Kontrolna tabla",
  "SIDEBAR_USERS_TITLE": "Korisnici",
  "SIDEBAR_WINERY_TITLE": "Vinarije",
  "SIDEBAR_WINES_TITLE": "Vina",
  "SIDEBAR_EVENTS_TITLE": "Dešavanja",
  "SIDEBAR_WINE_PATH_TITLE": "Vinski putevi",
  "SIDEBAR_POINT_OF_INTEREST_TITLE": "Tačke od interesa",
  "SIDEBAR_ARTICLES_TITLE": "Vesti",
  "SIDEBAR_COMMENTS_TITLE": "Komentari",
  "SIDEBAR_PUSH_NOTIFICATIONS_TITLE": "Push notifikacije",
  "SIDEBAR_SETTINGS_TITLE": "Podešavanja",
  "SIDEBAR_SETTINGS_REGIONS_TITLE": "Regije",
  "SIDEBAR_SETTINGS_WINE_TYPE_TITLE": "Vrsta vina",
  "SIDEBAR_SETTINGS_WINE_SORT_TITLE": "Sorta vina",
  "SIDEBAR_SETTINGS_LANGUAGE_TITLE": "Jezici",
  "SIDEBAR_SETTINGS_CLASSIFICATION_TITLE": "Klasifikacija",

  "CONTROL_BOARD_WINERY_CARD_TITLE": "Vinarije",
  "CONTROL_BOARD_WINE_CARD_TITLE": "Vina",
  "CONTROL_BOARD_USER_CARD_TITLE": "Korisnici",
  "CONTROL_BOARD_EVENTS_CARD_TITLE": "Dešavanja",
  "CONTROL_BOARD_UPDATE_STATUS": "Ažurirano pre 4 minuta",

  "USERS_CARD_NAME": "Korisnici",
  "USERS_TABLE_NAME": "Ime",
  "USERS_TABLE_USER_TYPE": "Tip korisnika",
  "USERS_TABLE_ACTIONS": "Akcije",
  "USERS_ADD_BUTTON_TITLE": "Dodajte korisnika",
  "USERS_DROPDOWN_PLACEHOLDER": "Prikaži",
  "USERS_DROPDOWN_1_ELEMENT": "ALL",
  "USERS_DROPDOWN_2_ELEMENT": "Users",
  "USERS_DROPDOWN_3_ELEMENT": "Trusted",
  "USERS_DROPDOWN_4_ELEMENT": "Admins",
  "USERS_DROPDOWN_5_ELEMENT": "Winery admin",

  "USERS_PASSWORD_REQUIREMENTS_LONG_LABEL": "Lozinka mora biti duža od 8 karaktera",
  "USERS_PASSWORD_REQUIREMENTS_LOW_CASE_LABEL": "Lozinka mora imati najmanje 1 malo slovo",
  "USERS_PASSWORD_REQUIREMENTS_UPPER_CASE_LABEL": "Lozinka mora imati najmanje 1 veliko slovo",
  "USERS_PASSWORD_REQUIREMENTS_NUMBER_LABEL": "Lozinka mora imati najmanje 1 broj",
  "USERS_PASSWORD_REQUIREMENTS_SPECIAL_CHAR_LABEL": "Lozinka mora imati najmanje 1 specijalani karakter",

  "USERS_ADD_CARD_NAME": "Forma za registraciju korisnika",
  "USERS_ADD_USER_NAME_LABEL": "Ime korisnika",
  "USERS_ADD_USER_NAME_PLACEHOLDER": "Ime",
  "USERS_ADD_USER_EMAIL_LABEL": "Email",
  "USERS_ADD_USER_EMAIL_PLACEHOLDER": "primer@gmail.rs",
  "USERS_ADD_USER_PASSWORD_LABEL": "Lozinka",
  "USERS_ADD_USER_PASSWORD_PLACEHOLDER": "Lozinka",
  "USERS_ADD_USER_PASSWORD_CONFIRM_LABEL": "Potvrdite lozinku",
  "USERS_ADD_USER_PASSWORD_CONFIRM_PLACEHOLDER": "Potvrdite lozinku",
  "USERS_ADD_TOOLTIP_EYE": "Prikaži lozinku",
  "USERS_ADD_USER_SELECT_TYPE_LABEL": "Izaberite tip",
  "USERS_ADD_USER_SELECT_WINERIES_LABEL": "Izaberite vinarije",
  "USERS_ADD_REGISTER_BUTTON_LABEL": "Registruj",
  "USERS_ADD_BACK_BUTTON_LABEL": "Nazad",

  "USERS_EDIT_USER_PROFILE": "Korisnički profil",
  "USERS_EDIT_CARD_NAME": "Forma za uređivanje podataka o Administratoru",
  "USERS_EDIT_USER_NAME_LABEL": "Ime korisnika",
  "USERS_EDIT_USER_NAME_PLACEHOLDER": "Ime",
  "USERS_EDIT_USER_EMAIL_LABEL": "Email",
  "USERS_EDIT_USER_EMAIL_PLACEHOLDER": "primer@gmail.rs",
  "USERS_EDIT_USER_OLD_PASSWORD_LABEL": "Stara lozinka",
  "USERS_EDIT_USER_OLD_PASSWORD_PLACEHOLDER": "Unesite staru lozinku",
  "USERS_EDIT_USER_NEW_PASSWORD_LABEL": "Nova lozinka",
  "USERS_EDIT_USER_NEW_PASSWORD_PLACEHOLDER": "Unesite novu lozinku",
  "USERS_EDIT_USER_CONFIRM_NEW_PASSWORD_LABEL": "Potvrdi novu lozinku",
  "USERS_EDIT_USER_CONFIRM_NEW_PASSWORD_PLACEHOLDER": "potvdite novu lozinku",
  "USERS_EDIT_TOOLTIP_EYE": "Prikaži lozinku",
  "USERS_EDIT_USER_SELECT_TYPE_LABEL": "Izaberite tip",
  "USERS_EDIT_USER_SELECT_WINERIES_LABEL": "Izaberite vinarije",
  "USERS_EDIT_REGISTER_BUTTON_LABEL": "Sačuvaj",
  "USERS_EDIT_BACK_BUTTON_LABEL": "Nazad",
  "USERS_EDIT_ADDITIONAL_TIPS": "Izmenu mozete sačuvati i bez promene lozinke!",

  "USERS_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete korisnika",
  "USERS_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "USERS_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "USERS_ALERT_MSG_DELETE_SUCCESS_TEXT": "je uspesno obrisan!.",
  "USERS_ALERT_MSG_DELETE_UNSUCCESS": "Greška korisnik nije obrisan",
  "USERS_ALERT_MSG_CHANGE_TYPE_SUCCESS": "Tip korisnika je uspešno izmenjen",
  "USERS_ALERT_MSG_SUCCESS_CREATE": "Uspešno ste dodali novog korisnika",
  "USERS_ALERT_MSG_SUCCESS_PATCH": "Uspešno ste izmenili podatke",
  "USERS_ALERT_MSG_WRONG_PASSWORD": "Greška pogrešno uneta lozinka",
  "USERS_ALERT_MSG_ERROR_PASSWORD_LENGTH": "Greška uneta lozinka treba da bude duža od 8 karatera",
  "USERS_ALERT_MSG_ERROR_EMAIL": "email adresa već postoji u bazi, molimo izaberite drugu",

  "WINERY_CARD_NAME": "Vinarije",
  "WINERY_TABLE_NAME": "Ime",
  "WINERY_TABLE_ADDRESS": "Adresa",
  "WINERY_TABLE_REGION": "Regija",
  "WINERY_TABLE_OPTIONS": "Opcije",
  "WINERY_TABLE_ACTIONS": "Akcije",
  "WINERY_TABLE_ALERT_MSG_DEACTIVATE": "deaktivirana",
  "WINERY_TABLE_ALERT_MSG_ACTIVATE": "aktivirana",

  "WINERY_ADD_CARD_NAME": "Forma za dodavanje vinarija",
  "WINERY_ADD_WINERY_NAME_LABEL": "Ime vinarije",
  "WINERY_ADD_WINERY_NAME_PLACEHOLDER": "Ime",
  "WINERY_ADD_WINERY_DESC_LABEL": "Opis vinarije",
  "WINERY_ADD_WINERY_DESC_PLACEHOLDER": "Opis...",
  "WINERY_ADD_WORKING_HOURS_LABEL": "Radno vreme",
  "WINERY_ADD_MONDAY_FIRDAY": "Ponedeljak - Petak",
  "WINERY_ADD_SATURDAY": "Subota",
  "WINERY_ADD_SUNDAY": "Nedelja",
  "WINERY_ADD_START_HOURS_PLACEHOLDER": "Početak",
  "WINERY_ADD_END_HOURS_PLACEHOLDER": "Kraj",
  "WINERY_ADD_RECOMMENDED_LABEL": "Preporučeno",
  "WINERY_ADD_HIGHLIGHTED_LABEL": "Izdvojeno",
  "WINERY_ADD_REGION_LIST_LABEL": "Izaberi regiju",
  "WINERY_ADD_REON_LIST_LABEL": "Izaberi rejon",
  "WINERY_ADD_VINOGORJE_LIST_LABEL": "Izaberi vinogorje",
  "WINERY_ADD_PHONE_NO_LABEL": "Telefon",
  "WINERY_ADD_PHONE_NO_PLACEHOLDER": "Broj telefona primer: +381 099 111 222",
  "WINERY_ADD_PHONE_PATTERN_ERROR": "broj telefona nije ispravno unet <strong>molimo proverite format</strong>",
  "WINERY_ADD_PHONE_CONTACT_LABEL": "Kontakt",
  "WINERY_ADD_PHONE_CONTACT_PLACEHOLDER": "Ime osobe za kontakt",
  "WINERY_ADD_WEB_PAGE_LABEL": "Web sajt",
  "WINERY_ADD_SELECT_WINERY_ADMIN_LABEL": "Izaberite admine vinarija",
  "WINERY_ADD_WEB_PAGE_PLACEHOLDER": "http://... ili https://...",
  "WINERY_ADD_LOCATION_CARD_TITLE": "Lokacija vinarije",
  "WINERY_ADD_WINERY_ADDRESS": "Adresa",
  "WINERY_ADD_LOCATION_TIPS": " <strong>U okviru polja <i>Adresa</i> unosite vinarije , a zatim bližu lokaciju odredite pomeranjem pina na mapi!</strong>",
  "WINERY_ADD_GALLERY_CARD_TITLE": "Galerija",
  "WINERY_ADD_ADD_BUTTON_TITLE": "Dodaj vinariju",

  "WINERY_EDIT_CARD_NAME": "Uređivanje vinarije",
  "WINERY_EDIT_WINERY_NAME_LABEL": "Ime vinarije",
  "WINERY_EDIT_WINERY_DESC_LABEL": "Opis vinarije",
  "WINERY_EDIT_WINERY_DESC_PLACEHOLDER": "Opis...",
  "WINERY_EDIT_WORKING_HOURS_LABEL": "Radno vreme",
  "WINERY_EDIT_MONDAY_FRIDAY": "Ponedeljak - Petak - Radno vreme:",
  "WINERY_EDIT_MONDAY_FRIDAY_NOT_WORKING": "Ponedeljak - Petak - Radno vreme: Ne radi",
  "WINERY_EDIT_SATURDAY": "Subota - Radno vreme:",
  "WINERY_EDIT_SATURDAY_NOT_WORKING": "Subota - Radno vreme: Ne radi",
  "WINERY_EDIT_SUNDAY": "Nedelja - Radno vreme:",
  "WINERY_EDIT_SUNDAY_NOT_WORKING": "Nedelja - Radno vreme: Ne radi",
  "WINERY_EDIT_START_HOURS_PLACEHOLDER": "Početak",
  "WINERY_EDIT_END_HOURS_PLACEHOLDER": "Kraj",
  "WINERY_EDIT_RECOMMENDED_LABEL": "Preporučeno",
  "WINERY_EDIT_HIGHLIGHTED_LABEL": "Izdvojeno",
  "WINERY_EDIT_REGION_LIST_LABEL": "Izaberi regiju",
  "WINERY_EDIT_REON_LIST_LABEL": "Izaberi rejon",
  "WINERY_EDIT_VINOGORJE_LIST_LABEL": "Izaberi vinogorje",
  "WINERY_EDIT_PHONE_NO_LABEL": "Telefon",
  "WINERY_EDIT_PHONE_NO_PLACEHOLDER": "Broj telefona primer: +381 099 111 222",
  "WINERY_EDIT_PHONE_CONTACT_LABEL": "Kontakt",
  "WINERY_EDIT_PHONE_CONTACT_PLACEHOLDER": "Osoba za kontakt",
  "WINERY_EDIT_WEB_PAGE_LABEL": "Web sajt",
  "WINERY_EDIT_SELECT_WINERY_ADMIN_LABEL": "Izaberite admine vinarija",
  "WINERY_EDIT_WEB_PAGE_PLACEHOLDER": "http://... ili https://...",
  "WINERY_EDIT_LOCATION_CARD_TITLE": "Lokacija vinarije",
  "WINERY_EDIT_WINERY_ADDRESS": "Adresa",
  "WINERY_EDIT_LOCATION_TIPS": "<strong>U okviru polja <i>Adresa</i> unosite vinarije , a zatim bližu lokaciju odredite pomeranjem pina namapi!</strong>",
  "WINERY_EDIT_GALLERY_CARD_TITLE": "Galerija",
  "WINERY_EDIT_ADD_BUTTON_TITLE": "Sačuvaj izmene",
  "WINERY_EDIT_CANCEL_TIME_TOOLTIP": "Ukloni radno vreme",

  "WINERY_PREVIEW_CARD_NAME": "Pregled vinarije",
  "WINERY_PREVIEW_WINERY_NAME_LABEL": "Ime vinarije",
  "WINERY_PREVIEW_WINERY_DESC_LABEL": "Opis vinarije",
  "WINERY_PREVIEW_LANG_TITLE": "{{language.language}} jezik - {{language.fields[1].value}}",
  "WINERY_PREVIEW_RECOMMENDED_TITLE": "Preporučeno",
  "WINERY_PREVIEW_YES": "Da",
  "WINERY_PREVIEW_NO": "Ne",
  "WINERY_PREVIEW_ADDRESS_TITLE": "Adresa",
  "WINERY_PREVIEW_WEB_PAGE_TITLE": "Web stranica",
  "WINERY_PREVIEW_NO_LINK": "Nema linka",
  "WINERY_PREVIEW_WORKING_HOURS_TITLE": "Radno vreme",
  "WINERY_PREVIEW_MONDAY_FRIDAY": "Od ponedeljka - do petka",
  "WINERY_PREVIEW_SATURDAY": "Subota",
  "WINERY_PREVIEW_SUNDAY": "Nedelja",
  "WINERY_PREVIEW_NOT_WORKING": "Ne radi",
  "WINERY_PREVIEW_CONTACT": "Kontakt",
  "WINERY_PREVIEW_AVG_RATE": "Prosečna ocena",
  "WINERY_PREVIEW_REGION_TITLE": "Regija",
  "WINERY_PREVIEW_REON_TITLE": "Reon",
  "WINERY_PREVIEW_VINOGORJE_TITLE": "Vinogorje",
  "WINERY_PREVIEW_WINE_CATEGORIES": "Kategorije vina",
  "WINERY_PRIVIEW_WINE_CATEGORIES_NO_RESULTS": "Nema rezultata!",
  "WINERY_PREVIEW_LOCATION_ON_MAP_TITLE": "Lokacija vinarije na mapi",
  "WINERY_PREVIEW_CREATE_AT_TITLE": "Kreirano",
  "WINERY_PREVIEW_UPDATE_AT_TITLE": "Ažurirano",
  "WINERY_PREVIEW_EDIT_BUTTON_TOOLTIP": "Uredi",
  "WINERY_PREVIEW_COMMENT_BUTTON_TOOLTIP": "Komentari",

  "WINERY_ALERT_MSG_MONDAY_FRIDAY_NOT_VALID": "niste ispravno uneli datum za ponedeljak - petak",
  "WINERY_ALERT_MSG_SATURDAY_NOT_VALID": "niste ispravno uneli datum za subotu",
  "WINERY_ALERT_MSG_SUNDAY_NOT_VALID": "niste ispravno uneli datum za nedelju",
  "WINERY_ALERT_MSG_SUCCESS_CREATE": "Uspešno ste kreirali novu vinariju!",
  "WINERY_ALERT_MSG_UNSUCCESS_CREATE": "Greška , niste uspešno sačuvali podatke!",
  "WINERY_ALERT_MSG_IMAGE_REMOVE_TITLE": "Da li ste sigurni da želite da uklonite sliku",
  "WINERY_ALERT_MSG_IMAGE_REMOVE_TEXT": "Slika ce biti obrisana!",
  "WINERY_ALERT_MSG_IMAGE_REMOVE_SUCCESS_TITLE": "Obrisano!",
  "WINERY_ALERT_MSG_IMAGE_REMOVE_SUCCESS_TEXT": "slika je uspesno obrisana!",
  "WINERY_ALERT_MSG_IMAGE_REMOVE_UNSUCCESS": "Greška! slika nije obrisana",
  "WINERY_ALERT_MSG_VIDEO_REMOVE_TITLE": "Da li ste sigurni da želite da uklonite video",
  "WINERY_ALERT_MSG_VIDEO_REMOVE_TEXT": "Video ce biti obrisan!",
  "WINERY_ALERT_MSG_VIDEO_REMOVE_SUCCESS_TITLE": "Obrisano!",
  "WINERY_ALERT_MSG_VIDEO_REMOVE_SUCCESS_TEXT": "video je uspesno obrisan!",
  "WINERY_ALERT_MSG_VIDEO_REMOVE_UNSUCCESS": "Greška! video nije obrisan",
  "WINERY_ALERT_MSG_SAVE_LANG_ALERT": "Upozorenje! Molimo Vas da sačuvate predhodni jezik!",
  "WINERY_ALERT_MSG_FALSE_FILE": "Greška promenite",
  "WINERY_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke!",
  "WINERY_ALERT_MSG_GALLERY_IMAGE_ERR": "Slika nije dodata",
  "WINERY_ALERT_MSG_NOT_VALID_UPLOADED_FILES": "Podaci nisu ispravno uneti molimo proverite!",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_TITLE": "Da li ste sigurni da želite da obrišete",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_SUCCESS_TITLE": "Obrisano!",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_SUCCESS_TEXT": "vinarija je uspesno obrisana!",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_UNSUCCESS_PART1": "Greska!",
  "WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_UNSUCCESS_PART2": "nije obrisana",

  "WINES_CARD_NAME": "Vina",
  "WINES_TABLE_NAME": "Ime",
  "WINES_TABLE_HARVEST_YEAR": "Godina berbe",
  "WINES_TABLE_WINERY_NAME": "Ime vinarije",
  "WINES_TABLE_OPTIONS": "Opcije",
  "WINES_TABLE_ACTIONS": "Akcije",
  "WINES_ADD_BUTTON_TOOLTIP": "Dodaj vino",
  "WINES_TABLE_ALERT_MSG_DEACTIVATE": "deaktivirana",
  "WINES_TABLE_ALERT_MSG_ACTIVATE": "aktivirana",

  "WINES_ADD_CARD_NAME": "Forma za dodavanje vina",
  "WINES_ADD_WINE_NAME": "Naziv vina",
  "WINES_ADD_WINE_NAME_PLACEHOLDER": "Naziv", 
  "WINES_ADD_WINE_DESC": "Opis vina",
  "WINES_ADD_WINE_DESC_PLACEHOLDER": "Opis...",
  "WINES_ADD_WINE_REQUIREMENTS_MSG_BACKGROUND_IMAGE": "OBAVEŠTENJE! Odaberite da li želite da postavite pozadinu za sliku vina",
  "WINES_ADD_WINE_REQUIREMENTS_MSG_FORMAT_IMAGE": "(postavi pozadinu) izaberite ukoliko je slika *jpg *jpeg formata, odnosno nema transparentu pozadinu",
  "WINES_ADD_WINE_REQUIREMENTS_MSG_RESOLUTION_IMAGE": "OBAVEŠTENJE! Slika mora biti rezolucije 100 x 340 zbog adekvatnog prikaza u Android Aplikaciji",
  "WINES_ADD_IMAGE_BACKGROUND_YES": "Postavi pozadinu",
  "WINES_ADD_IMAGE_BACKGROUND_NO": "Ukloni pozadinu",
  "WINES_ADD_RECOMMENDED_LABEL": "Preporučeno",
  "WINES_ADD_HIGHLIGHTED_LABEL": "Izdvojeno",
  "WINES_ADD_WINE_SORT_LABEL": "Sorta vina",
  "WINES_ADD_CLASSIFICATION_LABEL": "Klasifikacija",
  "WINES_ADD_WINE_CATEGORY_LABEL": "Kategorija vina",
  "WINES_ADD_WINERY_LABEL": "Vinarija",
  "WINES_ADD_REGION_LIST_LABEL": "Lista regija",
  "WINES_ADD_REON_LIST_LABEL": "Lista reona",
  "WINES_ADD_VINOGORJE_LIST_LABEL": "Lista vinogorja",
  "WINES_ADD_HARVEST_YEAR_LABEL": "Godina berbe",
  "WINES_ADD_HARVEST_YEAR_PLACEHOLDER": "Godina",
  "WINES_ADD_ALCOHOL_LABEL": "Alkohol",
  "WINES_ADD_ALCOHOL_PLACEHOLDER": "Alkohol u procentima",
  "WINES_ADD_TEMP_SERVING_LABEL": "Temperatura serviranja",
  "WINES_ADD_TEMP_SERVING_PLACEHOLDER": "Temperatura u celzijus",
  "WINES_ADD_ADD_BUTTON_TOOLTIP": "Dodaj vino",

  "WINES_EDIT_CARD_NAME": "Forma za uređivanje vina",
  "WINES_EDIT_WINE_NAME": "Naziv vina",
  "WINES_EDIT_WINE_NAME_PLACEHOLDER": "Naziv",
  "WINES_EDIT_WINE_DESC": "Opis vina",
  "WINES_EDIT_WINE_DESC_PLACEHOLDER": "Opis...",
  "WINES_EDIT_WINE_REQUIREMENTS_MSG_BACKGROUND_IMAGE": "OBAVEŠTENJE! Odaberite da li želite da postavite pozadinu za sliku vina",
  "WINES_EDIT_WINE_REQUIREMENTS_MSG_FORMAT_IMAGE": "(postavi pozadinu) izaberite ukoliko je slika *jpg *jpeg formata, odnosno nema transparentu pozadinu",
  "WINES_EDIT_WINE_REQUIREMENTS_MSG_RESOLUTION_IMAGE": "OBAVEŠTENJE! Slika mora biti rezolucije 100 x 340 zbog adekvatnog prikaza u Android Aplikaciji",
  "WINES_EDIT_IMAGE_BACKGROUND_YES": "Postavi pozadinu",
  "WINES_EDIT_IMAGE_BACKGROUND_NO": "Ukloni pozadinu",
  "WINES_EDIT_RECOMMENDED_LABEL": "Preporučeno",
  "WINES_EDIT_HIGHLIGHTED_LABEL": "Izdvojeno",
  "WINES_EDIT_WINE_SORT_LABEL": "Sorta vina",
  "WINES_EDIT_CLASSIFICATION_LABEL": "Klasifikacija",
  "WINES_EDIT_WINE_CATEGORY_LABLE": "Kategorija vina",
  "WINES_EDIT_WINERY_LABEL": "Vinarija",
  "WINES_EDIT_REGION_LIST_LABEL": "Lista regija",
  "WINES_EDIT_REON_LIST_LABEL": "Lista reona",
  "WINES_EDIT_VINOGORJE_LIST_LABEL": "Lista vinogorja",
  "WINES_EDIT_HARVEST_YEAR_LABEL": "Godina berbe",
  "WINES_EDIT_HARVEST_YEAR_PLACEHOLDER": "Godina",
  "WINES_EDIT_ALCOHOL_LABEL": "Alkohol",
  "WINES_EDIT_ALCOHOL_PLACEHOLDER": "Alkohol u procentima",
  "WINES_EDIT_TEMP_SERVING_LABEL": "Temperatura serviranja",
  "WINES_EDIT_TEMP_SERVING_PLACEHOLDER": "Temperatura u celzijus",
  "WINES_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "WINE_PREVIEW_CARD_NAME": "Pregled vina",
  "WINE_PREVIEW_WINE_NAME": "Ime vina",
  "WINE_PREVIEW_WINE_DESC": "Opis vina",
  "WINE_PREVIEW_RECOMMENDED_LABEL": "Preporučeno",
  "WINE_PREVIEW_YES": "Da",
  "WINE_PREVIEW_NO": "Ne",
  "WINE_PREVIEW_WINE_SORT_LABEL": "Sorta",
  "WINE_PREVIEW_REGION_LABEL": "Regija",
  "WINE_PREVIEW_REON_LABEL": "Reon",
  "WINE_PREVIEW_VINOGORJE_LABEL": "Vinogroje",
  "WINE_PREVIEW_WINE_CATEGORY_LABEL": "Kategorija vina",
  "WINE_PREVIEW_WINERY_NAME_LABEL": "Vinarija",
  "WINE_PREVIEW_AVG_RATE_LABEL": "Prosečna ocena",
  "WINE_PREVIEW_CREATE_AT_LABEL": "Kreirano",
  "WINE_PREVIEW_UPDATE_AT_LABEL": "Ažurirano",
  "WINE_PREVIEW_EDIT_BUTTON_TOOLTIP": "Uredi",
  "WINE_PREVIEW_COMMENT_BUTTON_TOOLTIP": "Komentari",

  "WINE_ALERT_MSG_SUCCESS_CREATE": "Uspešno ste kreirali vino!",
  "WINE_ALERT_MSG_UNSUCCESS_CREATE": "Greška, neuspešno kreiranje vina molimo proverite podatke!",
  "WINE_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke!",
  "WINE_ALERT_MSG_UNSUCCESS_EDITED": "Greška , niste uspešno sačuvali podatke!",
  "WINE_ALERT_MSG_SUBMIT_INVALID_IMAGE": "Greška slika nije odgovarajuceg formata, molimo proverite!",
  "WINE_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "WINE_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINE_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "WINE_ALERT_MSG_DELETE_SUCCESS_TEXT": "vino je uspešno obrisano",
  "WINE_ALERT_MSG_DELETE_UNSUCCESS": "Greška! vino nije obrisano",

  "EVENTS_CARD_NAME": "Dešavanja",
  "EVENTS_TABLE_NAME": "Naziv",
  "EVENTS_TABLE_START_DATE": "Datum početka",
  "EVENTS_TABLE_END_DATE": "Datum završetka",
  "EVENTS_TABLE_LOCATION": "Lokacija",
  "EVENTS_TABLE_ACTIONS": "Akcije",
  "EVENTS_ADD_BUTTON_TOOLTIP": "dodaj događaj",

  "EVENTS_ADD_CARD_NAME": "Forma za dodavanje vinskih dešavanja",
  "EVENTS_ADD_EVENTS_NAME": "Naziv dešavanja",
  "EVENTS_ADD_EVENTS_NAME_PLACEHOLDER": "Naziv",
  "EVENTS_ADD_EVENTS_DESC": "Opis dešavanja",
  "EVENTS_ADD_EVENTS_DESC_PLACEHOLDER": "Opis...",
  "EVENTS_ADD_RADIO_BUTTON_LINK": "Link",
  "EVENTS_ADD_RADIO_BUTTON_DESC": "Opis",
  "EVENTS_ADD_EVENTS_START_DATE_LABEL": "Datum početka",
  "EVENTS_ADD_EVENTS_START_DATE_PLACEHOLDER": "Unesi datum početka",
  "EVENTS_ADD_EVENTS_START_TIME_LABEL": "Vreme početka",
  "EVENTS_ADD_EVENTS_END_DATE_LABEL": "Datum završetka",
  "EVENTS_ADD_EVENTS_END_DATE_PLACEHOLDER": "Unesite datum završetka",
  "EVENTS_ADD_EVENTS_END_TIME_LABEL": "Vreme završetka",
  "EVENTS_ADD_EVENTS_LINK_LABEL": "Link",
  "EVENTS_ADD_EVENTS_LINK_PLACEHOLDER": "http://www... ili https://www...",
  "EVENTS_ADD_EVENTS_LOCATION_CARD_NAME": "Mesto dešavanja",
  "EVENTS_ADD_EVENTS_ADDRESS_LABEL": "Adresa",
  "EVENTS_ADD_EVENTS_ADDRESS_PLACHOLDER": "Adresa",
  "EVENTS_ADD_ADD_BUTTON_TOOLTIP": "Dodaj događaj",
  "EVENTS_ADD_LOCATION_TIPS": "<strong>U okviru polja <i>Adresa</i> unosite lokaciju , a zatim je tačnije odredite pomeranjem pina na mapi!</strong>",

  "EVENTS_EDIT_CARD_NAME": "Forma za uređivanje vinskih dešavanja",
  "EVENTS_EDIT_EVENTS_NAME": "Naziv dešavanja",
  "EVENTS_EDIT_EVENTS_NAME_PLACEHOLDER": "Naziv",
  "EVENTS_EDIT_EVENTS_DESC": "Opis dešavanja",
  "EVENTS_EDIT_EVENTS_DESC_PLACEHOLDER": "Opis...",
  "EVENTS_EDIT_RADIO_BUTTON_LINK": "Link",
  "EVENTS_EDIT_RADIO_BUTTON_DESC": "Opis",
  "EVENTS_EDIT_EVENTS_START_DATE_LABEL": "Datum početka",
  "EVENTS_EDIT_EVENTS_START_DATE_PLACEHOLDER": "Unesi datum početka",
  "EVENTS_EDIT_EVENTS_START_TIME_LABEL": "Vreme početka",
  "EVENTS_EDIT_EVENTS_END_DATE_LABEL": "Datum završetka",
  "EVENTS_EDIT_EVENTS_END_DATE_PLACEHOLDER": "Unesite datum završetka",
  "EVENTS_EDIT_EVENTS_END_TIME_LABEL": "Vreme završetka",
  "EVENTS_EDIT_EVENTS_LINK_LABEL": "Link",
  "EVENTS_EDIT_EVENTS_LINK_PLACEHOLDER": "http://www... ili https://www...",
  "EVENTS_EDIT_EVENTS_LOCATION_CARD_NAME": "Mesto dešavanja",
  "EVENTS_EDIT_EVENTS_ADDRESS_LABEL": "Adresa",
  "EVENTS_EDIT_EVENTS_ADDRESS_PLACHOLDER": "Adresa",
  "EVENTS_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",
  "EVENTS_EDIT_LOCATION_TIPS": "<strong>U okviru polja <i>Adresa</i> unosite lokaciju , a zatim je tačnije odredite pomeranjem pina na mapi!</strong>",

  "EVENTS_REVIEW_CARD_NAME": "Pregled dešavanja",
  "EVENTS_REVIEW_EVENTS_NAME": "Naziv dešavanja",
  "EVENTS_REVIEW_EVENTS_DESC": "Opis dešavanja",
  "EVENTS_REVIEW_START_DATE_TIME_LABEL": "Datum i vreme početka",
  "EVENTS_REVIEW_END_DATE_TIME_LABEL": "Datum i vreme završetka",
  "EVENTS_REVIEW_LOCATION_LABEL": "Lokacija",
  "EVENTS_REVIEW_LINK_LABEL": "Link",
  "EVENTS_REVIEW_CREATED_AT_LABEL": "Kreirano",
  "EVENTS_REVIEW_UPDATED_AT_LABEL": "Ažurirano",
  "EVENTS_REVIEW_MAP_LOCATION_TITLE": "Lokacija vinarije na mapi",
  "EVENTS_REVIEW_BUTTON_TOOLTIP": "Uredi",

  "EVENTS_ALERT_MSG_SUCCESS_CREATED": "Uspešno ste dodali novi događaj",
  "EVENTS_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke!",
  "EVENTS_ALERT_MSG_UNSUCCESS": "Greška , niste uspešno sačuvali podatke!",
  "EVENTS_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "EVENTS_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "EVENTS_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "EVENTS_ALERT_MSG_DELETE_SUCCESS_TEXT": "događaj je uspešno obrisan!",
  "EVENTS_ALERT_MSG_DELETE_UNSUCCESS": "Greška! nije obrisan",

  "WINE_PATH_SEARCH_LABEL": "Ukucaj termin pretrage",
  "WINE_PATH_SEARCH_PLACEHOLDER": "Ukucaj termin pretrage",
  "WINE_PATH_LANG_LABEL": "Jezik",
  "WINE_PATH_ADD_BUTTON_TOOLTIP": "Dodavanja vinskog puta",

  "WINE_PATH_ADD_WINE_PATH_NAME": "Naziv vinskog puta",
  "WINE_PATH_ADD_LANG_NAME_TITLE": "Naziv",
  "WINE_PATH_ADD_SEARCH_POI_LABEL": "Pretraži tačke od interesa iz baze",
  "WINE_PATH_ADD_SEARCH_POI_PLACEHOLDER": "Pretraži tačke od interesa iz baze",
  "WINE_PATH_ADD_WINE_PATH_MAP_TITLE": "Mapa (kliknite za dodavanje markera)",
  "WINE_PATH_ADD_WINE_PATH_MAP_TIP": "Klikom na mapu obeležavate tačke od interesa i morate uneti minimum dve tačke kako bi ste kreirali vinski put.",
  "WINE_PATH_ADD_WINE_PATH_MAP_TIP2": "a zatim bližu lokaciju odredite pomeranjem pina na mapi!",
  "WINE_PATH_ADD_WINE_PATH_POI_NAME_LABEL": "Naziv tačke",
  "WINE_PATH_ADD_WINE_PATH_ADDRESS_LABEL": "Adresa",
  "WINE_PATH_ADD_WINE_PATH_TYPE_LABEL": "Tip tačke",
  "WINE_PATH_ADD_WINE_PATH_REMOVE_POI_TOOLTIP": "Obrisi",
  "WINE_PATH_ADD_ADD_BUTTON_TOOLTIP": "Dodaj",

  "WINE_PATH_EDIT_WINE_PATH_NAME": "Naziv vinskog puta",
  "WINE_PATH_EDIT_LANG_NAME_TITLE": "Naziv",
  "WINE_PATH_EDIT_SEARCH_POI_LABEL": "Pretraži tačke od interesa iz baze",
  "WINE_PATH_EDIT_SEARCH_POI_PLACEHOLDER": "Pretraži tačke od interesa iz baze",
  "WINE_PATH_EDIT_WINE_PATH_MAP_TITLE": "Mapa (kliknite za dodavanje markera)",
  "WINE_PATH_EDIT_WINE_PATH_MAP_TIP": "Klikom na mapu obeležavate tačke od interesa i morate uneti minimum dve tačke kako bi ste kreirali vinski put.",
  "WINE_PATH_EDIT_WINE_PATH_MAP_TIP2": "a zatim bližu lokaciju odredite pomeranjem pina na mapi!",
  "WINE_PATH_EDIT_WINE_PATH_POI_NAME_LABEL": "Naziv tacke",
  "WINE_PATH_EDIT_WINE_PATH_POI_NAME_PLACEHOLDER": "Naziv tačke",
  "WINE_PATH_EDIT_WINE_PATH_ADDRESS_LABEL": "Adresa",
  "WINE_PATH_EDIT_WINE_PATH_ADDRESS_PLACEHOLDER": "Adresa",
  "WINE_PATH_EDIT_WINE_PATH_TYPE_LABEL": "Tip tačke",
  "WINE_PATH_EDIT_WINE_PATH_REMOVE_POI_TOOLTIP": "Obrisi",
  "WINE_PATH_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "WINE_PATH_ALERT_MSG_MIN_MARKERS_ERR": "Vinski put mora sadržati minimum dve tačke.",
  "WINE_PATH_ALERT_MSG_SUCCESS_CREATED": "Vinski put uspešno kreiran.",
  "WINE_PATH_ALERT_MSG_WINDOWS_ALERT_MAX_NO_POINTS": "Maksimalni broj markera je iskoriščen",
  "WINE_PATH_ALERT_MSG_SUCCESS_EDITED": "Vinski put uspešno izmenjen.",
  "WINE_PATH_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete vinski put",
  "WINE_PATH_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINE_PATH_ALERT_MSG_CANNOT_ADD_MARKER": "Nije moguće dodati marker na ovom mestu!",
  "WINE_PATH_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "WINE_PATH_ALERT_MSG_DELETE_SUCCESS_TEXT": "Vinski put je obrisan!",

  "POI_CARD_NAME": "Tačke od interesa",
  "POI_SEARCH_LABEL": "Pretražite po nazivu ili adresi",
  "POI_ADD_BUTTON_TOOLTIP": "Dodaj tačku od interesa",
  "POI_TABLE_NAME": "Ime",
  "POI_TABLE_ADDRESS": "Adresa",
  "POI_TABLE_TYPE": "Tip",
  "POI_TABLE_ACTIONS": "Akcije",

  "POI_ADD_POI_NAME": "Naziv tačke od interesa",
  "POI_ADD_LANG_NAME_TITLE": "Naziv",
  "POI_ADD_POI_ADDRESS_LABEL": "Adresa",
  "POI_ADD_POI_TYPE_LABEL": "Tip tacke",
  "POI_ADD_POI_MAP_TITLE": "Mapa (kliknite za dodavanje markera)",
  "POI_ADD_POI_MAP_TIP": "U okviru polja <i>Adresa</i> unosite tačke od interesa , a zatim bližu lokaciju odredite pomeranjem pina na mapi!",
  "POI_ADD_ADD_BUTTON_TOOLTIP": "Dodaj tacku od interesa",
  "POI_ADD_MODAL_MSG": "Ne mozete dodati marker na ovom mestu",

  "POI_EDIT_POI_NAME": "Naziv tačke od interesa",
  "POI_EDIT_LANG_NAME_TITLE": "Naziv",
  "POI_EDIT_POI_ADDRESS_LABEL": "Adresa",
  "POI_EDIT_POI_TYPE_LABEL": "Tip tacke",
  "POI_EDIT_POI_MAP_TITLE": "Mapa (kliknite za dodavanje markera)",
  "POI_EDIT_POI_MAP_TIP": "U okviru polja <i>Adresa</i> unosite tačke od interesa , a zatim bližu lokaciju odredite pomeranjem pina na mapi!",
  "POI_EDIT_ADD_BUTTON_TOOLTIP": "Sačuvaj izmene",
  "POI_EDIT_MODAL_MSG": "Ne mozete dodati marker na ovom mestu",

  "POI_ALERT_MSG_MARKER_ERR": "Neophodno je dodati marker na mapu.",
  "POI_ALERT_MSG_SUCCESS_CREATED": "Tačka od interesa uspešno dodata.",
  "POI_ALERT_MSG_SUCCESS_EDITED": "Tačka od interesa uspešno izmenjena.",
  "POI_ALERT_MSG_CANNOT_ADD_MARKER": "Nije moguće dodati marker na ovom mestu!",
  "POI_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete tačku od interesa",
  "POI_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "POI_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "POI_ALERT_MSG_DELETE_SUCCESS_TEXT": "Tačka od interesa je obrisana",

  "ARTICLES_CARD_NAME": "Vesti",
  "ARTICLES_TABLE_CREATED": "Kreirano",
  "ARTICLES_TABLE_NAME": "Naziv",
  "ARTICLES_TABLE_TEXT": "Tekst",
  "ARTICLES_TABLE_LINK": "Link",
  "ARTICLES_TABLE_ACTIONS": "Akcije",
  "ARTICLES_ADD_BUTTON_TOOLTIP": "Dodaj članak",

  "ARTICLES_ADD_CARD_NAME": "Forma za dodavanje članka",
  "ARTICLES_ADD_ARTICLES_NAME_LABEL": "Naslov članka",
  "ARTICLES_ADD_ARTICLES_NAME_PLACEHOLDER": "Naslov",
  "ARTICLES_ADD_ARTICLES_TEXT_LABEL": "Tekst",
  "ARTICLES_ADD_ARTICLES_TEXT_PLACEHOLDER": "Tekst članka...",
  "ARTICLES_ADD_DISABLE_CHECKBOX_LABEL": "Onemogući tekst",
  "ARTICLES_ADD_ARTICLES_LINK_LABEL": "Link",
  "ARTICLES_ADD_ARTICLES_LINK_PLACEHOLDER": "http://www... ili https://www...",
  "ARTICLES_ADD_ADD_BUTTON_TOOLTIP": "Dodaj članak",

  "ARTICLES_EDIT_CARD_NAME": "Forma za uređivanje članka",
  "ARTICLES_EDIT_ARTICLES_NAME_LABEL": "Naslov šlanka",
  "ARTICLES_EDIT_ARTICLES_NAME_PLACEHOLDER": "Naslov",
  "ARTICLES_EDIT_ARTICLES_TEXT_LABEL": "Tekst",
  "ARTICLES_EDIT_ARTICLES_TEXT_PLACEHOLDER": "Tekst članka...",
  "ARTICLES_EDIT_DISABLE_CHECKBOX_LABEL": "Onemogući tekst",
  "ARTICLES_EDIT_ARTICLES_LINK_LABEL": "Link",
  "ARTICLES_EDIT_ARTICLES_LINK_PLACEHOLDER": "http://www... ili https://www...",
  "ARTICLES_EDIT_ADD_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "ARTICLES_REVIEW_MODAL_CARD_NAME": "Pregled članka",
  "ARTICLES_REVIEW_MODAL_TITLE": "Naslov",
  "ARTICLES_REVIEW_MODAL_TEXT": "Tekst",
  "ARTICLES_REVIEW_MODAL_IMAGE": "Slika",
  "ARTICLES_REVIEW_MODAL_LINK": "link",
  "ARTICLES_REVIEW_MODAL_CREATED_AT": "Kreirano",
  "ARTICLES_REVIEW_BUTTON_LABEL": "U redu",

  "ARTICLES_ALERT_MSG_SUCCESS_CREATED": "Članak je uspešno kreiran.",
  "ARTICLES_ALERT_MSG_SUCCESS_EDITED": "Članak je usprešno izmenjen",
  "ARTICLES_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete članak",
  "ARTICLES_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "ARTICLES_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "ARTICLES_ALERT_MSG_DELETE_SUCCESS_TEXT": "članak je uspesno obrisan!",
  "ARTICLES_ALERT_MSG_DELETE_UNSUCCESS": "Desila se greška , članak nije obrisan",
  "ARTICLES_ALERT_MSG_IMAGE_INVALID": "Slika nije validna, ubacite novu",

  "RATE_CARD_NAME": "Komentari",
  "RATE_TABLE_CREATED": "Kreirano",
  "RATE_TABLE_USER_NAME": "Ime korisnika",
  "RATE_TABLE_COMMENT": "Komentar",
  "RATE_TABLE_RATE": "Ocena",
  "RATE_TABLE_STATUS": "Status",
  "RATE_TABLE_DELETE": "Brisanje",
  "RATE_SELECT_SECTION_LABEL": "Izaberite sekciju (vino, vinarija)",
  "RATE_SELECT_WINE_LABEL": "Izaberite vino iz liste",
  "RATE_SELECT_WINERY_LABEL": "Izaberite vinariju iz liste",
  "RATE_SELECT_FILTER_LABEL": "Prikaži",
  "RATE_SELECT_FILTER_ALL": "Sve",
  "RATE_SELECT_FILTER_APPROVED": "Odobreni",
  "RATE_SELECT_FILTER_DEAPPROVED": "Odbijeni",
  "RATE_SELECT_FILTER_HOLD": "Na čekanju",

  "RATE_PREVIEW_MODAL_CARD_NAME": "Odobravanje komentara",
  "RATE_PREVIEW_MODAL_STATUS": "Status",
  "RATE_PREVIEW_MODAL_STATUS_LABELS_APPROVED": "odobren",
  "RATE_PREVIEW_MODAL_STATUS_LABELS_DEAPPROVED": "odbijen",
  "RATE_PREVIEW_MODAL_STATUS_LABELS_HOLD": "na čekanju",
  "RATE_PREVIEW_MODAL_NAME": "Ime",
  "RATE_PREVIEW_MODAL_COMMENT": "Komentar",
  "RATE_PREVIEW_MODAL_CREATED": "Kreirano",
  "RATE_PREVIEW_MODAL_RATE": "Ocena",
  "RATE_PREVIEW_MODAL_APPROVE_BUTTON_LABEL": "Odobri",
  "RATE_PREVIEW_MODAL_DEAPPROVED_BUTTON_LABEL": "Odbaci",
  "RATE_PREVIEW_MODAL_IMAGE": "Slika",

  "RATE_ALERT_MSG_DELETE_RATE_TITLE": "Da li ste sigurni da želite da obrišete komentar?",
  "RATE_ALERT_MSG_DELETE_RATE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "RATE_ALERT_MSG_DELETE_RATE_SUCCESS_TITLE": "Obrisano!",
  "RATE_ALERT_MSG_DELETE_RATE_SUCCESS_TEXT": "Komentar je uspešno obrisan!",
  "RATE_ALERT_MSG_DELETE_UNSUCCESS": "Greška! komentar nije obrisan",
  "RATE_ALERT_MSG_DEAPPROVED_TITLE": "Odbijeno!",
  "RATE_ALERT_MSG_DEAPPROVED": "Komentar je odbijen i nece biti objavljen!",
  "RATE_ALERT_MSG_APPROVED_TITLE": "Odobreno!",
  "RATE_ALERT_MSG_APPROVED": "Komentar je odobren!",


  "PUSH_NOTIFICATIONS_CARD_NAME": "Kreiranje obavestenja",
  "PUSH_NOTIFICATIONS_TITLE": "Naslov",
  "PUSH_NOTIFICATIONS_TITLE_PLACEHOLDER": "Naslov",
  "PUSH_NOTIFICATIONS_TEXT": "Tekst",
  "PUSH_NOTIFICATIONS_TEXT_PLACEHOLDER": "Tekst",
  "PUSH_NOTIFICATIONS_CHECKBOX_LABEL": "Kritična poruka",
  "PUSH_NOTIFICATIONS_SELECT_LABEL": "Pošalji na",
  "PUSH_NOTIFICATIONS_SEND_BUTTON_LABEL": "Pošalji obaveštenje",

  "PUSH_ALERT_MSG_SUCCES_CREATED": "Uspešno ste kreirali novo obaveštenje",

  "REGIONS_REGIONS_CARD_NAME": "Regije",
  "REGIONS_REONS_CARD_NAME": "Reoni",
  "REGIONS_VINOGORJE_CARD_NAME": "Vinogorja",
  "REGIONS_TABLE_NAME": "Naziv",
  "REGIONS_TABLE_ACTIONS": "Akcije",
  "REGIONS_ADD_BUTTON_TOOLTIP": "Dodaj",
  "REGIONS_ADD_BUTTON_REGION": "Regija",
  "REGIONS_ADD_BUTTON_REON": "Reon",
  "REGIONS_ADD_BUTTON_VINOGORJE": "Vinogorje",
  "REGIONS_REGIONS_CREATE_CARD_NAME": "Regija",
  "REGIONS_REONS_CREATE_CARD_NAME": "Rejona",
  "REGIONS_VINOGORJE_CREATE_CARD_NAME": "Vinogorja",

  "REGIONS_ADD_CARD_NAME": "Kreiranje regija",
  "REGIONS_ADD_REGION_LIST": "Izaberi regiju",
  "REGIONS_ADD_REON_LIST": "Izaberi rejon",
  "REGIONS_ADD_REGION_NAME": "Naziv nove regije",
  "REGIONS_ADD_REGION_NAME_PLACEHOLDER": "Regija",
  "REGIONS_ADD_REGION_DESC": "Opis nove regije",
  "REGIONS_ADD_REGION_DESC_PLACEHOLDER": "Opis regije",
  "REGIONS_ADD_REON_NAME": "Naziv novog reona",
  "REGIONS_ADD_REON_NAME_PLACEHOLDER": "Reon",
  "REGIONS_ADD_REON_DESC": "Opis novog reona",
  "REGIONS_ADD_REON_DESC_PLACEHOLDER": "Opis reona",
  "REGIONS_ADD_VINOGORJA_NAME": "Naziv novog vinogorja",
  "REGIONS_ADD_VINOGORJA_NAME_PLACEHOLDER": "Vinogorje",
  "REGIONS_ADD_VINOGORJA_DESC": "Opis novog vinogorja",
  "REGIONS_ADD_VINOGORJA_DESC_PLACEHOLDER": "Opis vinogorja",
  "REGIONS_ADD_POLYGON_CARD_NAME": "Poligon regije",
  "REGIONS_ADD_MAP_TITLE": "Klikni na mapu za dodavanje markera i iscrtavanje poligona",
  "REGIONS_ADD_ADD_BUTTON_TOOLTIP": "Dodaj regiju",

  "REGIONS_EDIT_CARD_NAME": "Uređivanje regija",
  "REGIONS_EDIT_REGION_LIST": "Izaberi regiju",
  "REGIONS_EDIT_REON_LIST": "Izaberi rejon",
  "REGIONS_EDIT_REGION_NAME": "Naziv regije",
  "REGIONS_EDIT_REGION_NAME_PLACEHOLDER": "Regija",
  "REGIONS_EDIT_REGION_DESC": "Opis regije",
  "REGIONS_EDIT_REGION_DESC_PLACEHOLDER": "Opis regije",
  "REGIONS_EDIT_REON_NAME": "Naziv reona",
  "REGIONS_EDIT_REON_NAME_PLACEHOLDER": "Opis reona",
  "REGIONS_EDIT_REON_DESC": "Opis reona",
  "REGIONS_EDIT_REON_DESC_PLACEHOLDER": "Opis reona",
  "REGIONS_EDIT_VINOGORJA_NAME": "Naziv vinogorja",
  "REGIONS_EDIT_VINOGORJA_NAME_PLACEHOLDER": "Vinogorje",
  "REGIONS_EDIT_VINOGORJA_DESC": "Opis vinogorja",
  "REGIONS_EDIT_VINOGORJA_DESC_PLACEHOLDER": "Opis vinogorja",
  "REGIONS_EDIT_POLYGON_CARD_NAME": "Poligon regije",
  "REGIONS_EDIT_MAP_TITLE": "Klikni na mapu za dodavanje markera i iscrtavanje poligona",
  "REGIONS_EDIT_ADD_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "REGIONS_ALERT_MSG_POLYGON_PATTERN": "Morate uneti minimum 3 tačke na mapi za kreiranje poligona",
  "REGIONS_ALERT_MSG_WINDOWS_ALERT": "Nije moguće dodati marker na ovom mestu.",
  "REGIONS_ALERT_MSG_SUCCESS_CREATE": "Uspešno ste dodali",
  "REGIONS_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste sačuvali izmene za",
  "REGIONS_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "REGIONS_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "REGIONS_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "REGIONS_ALERT_MSG_DELETE_SUCCESS_TEXT": "je uspesno obrisano/a",
  "REGIONS_ALERT_MSG_NOT_ALLOWED_DELETE_REGIONS": "regiju nije moguće izbrisati!. Jer sadrži reone! molimo prvo izbrišite reone!",
  "REGIONS_ALERT_MSG_NOT_ALLOWED_DELETE_REONS": "reon nije moguće izbrisati!. Jer sadrži vingorja! molimo prvo izbrišite vinogorja!",
  "REGIONS_ALERT_MSG_DELETE_UNSUCCESS": "Greška nije moguće obrisati",

  "WINE_CATEGORIES_CARD_NAME": "Vrste vina",
  "WINE_CATEGORIES_TABLE_NAME": "Ime",
  "WINE_CATEGORIES_TABLE_ACTIONS": "Akcije",
  "WINE_CATEGORIES_ADD_BUTTON_TOOLTIP": "Dodaj vrstu vina",

  "WINE_CATEGORIES_ADD_WINE_CATEGORIES_NAME": "Naziv",
  "WINE_CATEGORIES_ADD_WINE_CATEGORIES_NAME_PLACEHOLDER": "Naziv",
  "WINE_CATEGORIES_ADD_ADD_BUTTON_TOOLTIP": "Dodaj vrstu vina",

  "WINE_CATEGORIES_EDIT_WINE_CATEGORIES_NAME": "Naziv",
  "WINE_CATEGORIES_EDIT_WINE_CATEGORIES_NAME_PLACEHOLDER": "Naziv",
  "WINE_CATEGORIES_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "WINE_CATEGORIES_ALERT_MSG_SUCCESS_CREATED": "Uspešno ste kreirali vrstu vina",
  "WINE_CATEGORIES_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke",
  "WINE_CATEGORIES_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "WINE_CATEGORIES_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINE_CATEGORIES_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "WINE_CATEGORIES_ALERT_MSG_DELETE_SUCCESS_TEXT": "vrsta vina je uspešno obrisana",
  "WINE_CATEGORIES_ALERT_MSG_DELETE_UNSUCCESS": "Greška! vrsta nije obrisana",

  "WINE_TYPE_CARD_NAME": "Klasifikacija vina",
  "WINE_TYPE_TABLE_NAME": "Ime",
  "WINE_TYPE_TABLE_DESC": "Opis",
  "WINE_TYPE_TABLE_ACTIONS": "Akcije",
  "WINE_TYPE_ADD_BUTTON_TOOLTIP": "Dodaj novu klasifikaciju vina",

  "WINE_TYPE_ADD_WINE_TYPE_NAME_LABEL": "Naziv",
  "WINE_TYPE_ADD_WINE_TYPE_NAME_PLACEHOLDER": "Naziv",
  "WINE_TYPE_ADD_WINE_TYPE_DESC_LABEL": "Opis",
  "WINE_TYPE_ADD_WINE_TYPE_DESC_PLACEHOLDER": "Opis",
  "WINE_TYPE_ADD_ADD_BUTTON_TOOLTIP": "Dodaj klasifikaciju vina",
  "WINE_TYPE_ADD_WINE_TYPE_COLOR_LABEL": "Izaberite boju",

  "WINE_TYPE_EDIT_WINE_TYPE_NAME_LABEL": "Naziv",
  "WINE_TYPE_EDIT_WINE_TYPE_NAME_PLACEHOLDER": "Naziv",
  "WINE_TYPE_EDIT_WINE_TYPE_DESC_LABEL": "Opis",
  "WINE_TYPE_EDIT_WINE_TYPE_DESC_PLACEHOLDER": "Opis",
  "WINE_TYPE_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "WINE_TYPE_ALERT_MSG_SUCCESS_CREATED": "Uspešno ste kreirali novu klasifikaciju vina!",
  "WINE_TYPE_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke!",
  "WINE_TYPE_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "WINE_TYPE_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINE_TYPE_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "WINE_TYPE_ALERT_MSG_DELETE_SUCCESS_TEXT": "Klasifikacija je uspesno obrisana",
  "WINE_TYPE_ALERT_MSG_DELETE_UNSUCCESS": "Greška! klasifikacija nije obrisana",

  "WINE_SORT_CARD_NAME": "Sorte vina",
  "WINE_SORT_TABLE_NAME": "Ime",
  "WINE_SORT_TABLE_DESC": "Opis",
  "WINE_SORT_TABLE_ACTIONS": "Akcije",
  "WINE_SORT_ADD_BUTTON_TOOLTIP": "Dodaj sortu vina",

  "WINE_SORT_ADD_WINE_SORT_NAME_LABEL": "Naziv",
  "WINE_SORT_ADD_WINE_SORT_NAME_PLACEHOLDER": "Naziv",
  "WINE_SORT_ADD_WINE_SORT_DESC_LABEL": "Opis",
  "WINE_SORT_ADD_WINE_SORT_DESC_PLACEHOLDER": "Opis",
  "WINE_SORT_ADD_ADD_BUTTON_TOOLTIP": "Dodaj sortu vina",

  "WINE_SORT_EDIT_WINE_SORT_NAME_LABEL": "Naziv",
  "WINE_SORT_EDIT_WINE_SORT_NAME_PLACEHOLDER": "Naziv",
  "WINE_SORT_EDIT_WINE_SORT_DESC_LABEL": "Opis",
  "WINE_SORT_EDIT_WINE_SORT_DESC_PLACEHOLDER": "Opis",
  "WINE_SORT_EDIT_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "WINE_SORT_ALERT_MSG_SUCCESS_CREATED": "Uspešno ste kreirali sortu vina!",
  "WINE_SORT_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste izmenili podatke!",
  "WINE_SORT_ALERT_MSG_DELETE_TITLE": "Da li ste sigurni da želite da obrišete",
  "WINE_SORT_ALERT_MSG_DELETE_TEXT": "Podatke nije moguće povratiti nakon brisanja!",
  "WINE_SORT_ALERT_MSG_DELETE_SUCCESS_TITLE": "Obrisano!",
  "WINE_SORT_ALERT_MSG_DELETE_SUCCESS_TEXT": "sorta je uspesno obrisana",
  "WINE_SORT_ALERT_MSG_DELETE_UNSUCCESS": "Greška! sorta nije obrisana",

  "LOGIN_CARD_TITLE": "vinovojo prijava",
  "LOGIN_EMAIL_LABEL": "Email",
  "LOGIN_EMAIL_PLACEHOLDER": "primer@gmail.com",
  "LOGIN_PASSWORD_LABEL": "Lozinka",
  "LOGIN_PASSWORD_PLACEHOLDER": "Lozinka",
  "LOGIN_BUTTON_TITLE": "LOGIN",

  "TRANSLATE_CARD_NAME": "Dodavanje i uređivanje jezika",
  "TRANSLATE_LANG_NAME_LABEL": "Naziv jezika",
  "TRANSLATE_LANG_CODE_LABEL": "Oznaka jezika",
  "TRANSLATE_LANG_MOBILE_TAB_TITLE": "Lista prevoda za mobilnu aplikaciju",
  "TRANSLATE_LANG_FRONTEND_TAB_TITLE": "Lista prevoda za admin panel",

  "TRANSLATE_EDIT_TABLE_NAME": "Ključ",
  "TRANSLATE_EDIT_TABLE_VALUE": "Prevod",
  "TRANSLATE_EDIT_BUTTON_TOOLTIP": "Sačuvaj izmene",

  "TRANSLATE_ADD_CARD_NAME": "Dodavanje novog jezika",
  "TRANSLATE_ADD_MOBILE_TAB_TITLE": "Prevod za mobilnu aplikaciju",
  "TRANSLATE_ADD_FRONT_END_TAB_TITLE": "Prevod za admin panel",
  "TRANSLATE_ADD_TABLE_KEY_NAME": "Ključ",
  "TRANSLATE_ADD_TABLE_EXAMPLE": "Primer prevoda",
  "TRANSLATE_ADD_TABLE_INPUT": "Prevod",
  "TRANSLATE_ADD_BUTTON_LABEL": "Dodaj jezik",
  "TRANSLATE_SAVE_BUTTON_LABEL": "Sačuvaj jezik",

  "TRANSLATE_ALERT_MSG_SUCCESS_CREATED": "Uspešno ste dodali novi jezik",
  "TRANSLATE_ALERT_MSG_SUCCESS_EDITED": "Uspešno ste sačuvali izmene",

  "LOGIN_ALERT_MSG_UNSUCCESS_LOGIN": "Email ili lozinka nisu ispravne, Molimo pokušajte ponovo",
  "LOGIN_ALERT_MSG_SUCCESS_LOGIN": "Dobro došli",

  "ADDONS_REQUIRED_FIELD_LABEL": "Polja obeležena <span class=\'star\'>*</span> su obavezna!",
  "ADDONS_FIELD_REQUIRED": "Ovo polje je <strong>obavezno!</strong>",
  "ADDONS_WEB_FIELD_PATTERN": "URL nije ispravan <strong>molimo proverite format http://www.primer.rs</strong>",
  "ADDONS_USERS_FIELD_PASSWORD_MISS_PATTERN": "Lozinka mora sadržati barem 1<strong> VELIKO SLOVO, malo slovo, specijalan znak (!@#$) i broj</strong>",
  "ADDONS_USERS_FIELD_CONFIRM_PASSWORD_NOT_EQUAL": "Lozinke se ne <strong>poklapaju</strong>",
  "ADDONS_USERS_FIELD_OLD_PASSWORD_NOT_CORRECT": "Stara lozinka nije tačna!",
  "ADDONS_USERS_FIELD_PASSWORD_LENGTH": "Uneta lozinka mora biti duža od 8 karaktera",
  "ADDONS_USERS_FIELD_EMAIL_PATTERN": "Uneta email adresa nije ispravna <strong>molimo proverite format</strong>",
  "ADDONS_USERS_FIELD_EMAIL_INVALID": "Email adresa se već nalazi u bazi!",

  "TABLES_ELEMENTS_PER_PAGE": "Elemenata po stranici",
  "TABLES_PREVIOUS_PAGE_TOOLTIP": "Predhodna",
  "TABLES_NEXT_PAGE_TOOPTIP": "Sledeća",
  "TABLES_PREVIEW_TOOLTIP": "Pregled",
  "TABLES_DELETE_TOOLTIP": "Obriši",
  "TABLES_EDIT_TOOLTIP": "Uredi",
  "TABLES_RECOMMENDED_TOOLTIP": "Označi kao preporučeno",
  "TABLES_HIGHLIGHTED_TOOLITP": "Označi kao istaknuto",
  "TABLES_IS_RECOMMENDED_TOOLTIP": "Preporučeno",
  "TABLES_IS_NOT_RECOMMENDED_TOOLTIP": "Nije preporučeno",
  "TABLES_IS_HIGHLIGHTED_TOOLTIP": "Istaknuto",
  "TABLES_IS_NOT_HIGHLIGHTED_TOOLTIP": "Nije istaknuto",
  "TABLES_CHOOSE_LANG_LABEL": "Izaberite jezik",
  "TABLES_SELECT": "Selektuj",
  "TABLES_CLICK_FOR_PREVIEW": "Klikni za pregled",
  "TABLES_RATE_STATUS_APPROVED": "Odobreno",
  "TABLES_RATE_STATUS_DEAPPROVED": "Odbijeno",
  "TABLES_RATE_STATUS_HOLD": "Na čekanju",

  "FILES_ALERT_MSG_VIDEO_FILE_IS_NOT_VIDEO": "Fajl nije video! molimo ubacite video",
  "FILES_ALERT_MSG_VIDEO_FILE_FORMAT": "Format video snimka nije podržan! podržani format: *MP4",
  "FILES_ALERT_MSG_IMAGE_FILE_IS_NOT_IMAGE": "Fajl nije slika! molimo ubacite sliku",
  "FILES_ALERT_MSG_IMAGE_FILE_FORMAT": "Format slike nije podržan! podržani formati: *jpg *jpeg *png",
  "FILES_ALERT_MSG_SERVER_ERRROR": "Greška na serveru, pokušajte kasnije",
  "FILES_ALERT_MSG_INVALID_IMAGE": "Slika nije validna, izaberite novu",
  "FILES_ALERT_MSG_INVALID_VIDEO_OR_IMAGE": "Slika ili video nisu validni, izaberite nove",

  "ALERT_BUTTONS_YES": "Da, obriši",
  "ALERT_BUTTONS_NO": "Ne",
  "ALERT_SERVER_ERROR": "Greška na serveru, pokušajte kasnije",

  "LOADING_TITLE": "Molimo sačekajte",

  "LANG_ADD_BUTTON_TITLE": "dodaj jezik",
  "LANG_DROPDOWN_TITLE": "Izaberite jezik",
  "LANG_DELETE_TOOLTIP": "Brisanje jezika",
  "LANG_SAVE_BUTTON_TITLE": "Sačuvaj jezik",
  "LANG_ALERT_SUCCESS_SAVED": "Uspešno ste sačuvali jezik",
  "LANG_ALERT_REQ_SAVE_PREVIOUS_LANG": "Upozorenje! Molimo Vas da sačuvate predhodni jezik!",

  "BUTTONS_ADD_IMAGE": "Izaberi sliku",
  "BUTTONS_ADD_COVER": "Izaberi naslovnu",
  "BUTTONS_ADD_VIDEO": "Izaberi video",
  "BUTTONS_ADD_BACKGROUND_IMAGE": "Izaberi sliku",
  "BUTTONS_CHANGE_IMAGE": "Promeni",
  "BUTTONS_REMOVE_IMAGE": "Ukloni",
  "BUTTONS_ADD_LANG": "Dodaj jezik",
  "BUTTONS_DELETE_LANG_TOOLTIP": "Brisanje jezika",
  "BUTTONS_DELETE_MARKERS": "Obriši",
  "BUTTONS_GALLERY_ADD_IMAGES": "Izaberite slike",
  "BUTTONS_GALLERY_ADD_VIDEOS": "Izaberite video",
  "BUTTONS_GALLERY_DELETE_VIDEO_TOOLTIP": "Ukloni video iz liste",
  "BUTTONS_GALLERY_DELETE_IMAGES_TOOLTIP": "Ukloni sliku iz galerije",

  "IMAGE_LOGO_TITLE": "Slika za logo",
  "IMAGE_COVER_TITLE": "Slika za naslovnu",
  "IMAGE_BACKGROUND_TITLE": "Slika za pozadinu",
  "VIDEO_TITLE": "Video snimak *MP4",
  "IMAGE_BOTTLE_TITLE": "Slika vina",
  "IMAGE_EXAMPLE": "Primer",

  "SWAL_DELETE_LANG_TITLE": "Da li ste sigurni da želite da uklonite",
  "SWAL_DELETE_LANG_TEXT": "Vrednosti polja biće trajno obrisane!",
  "SWAL_DELETE_LANG_SUCCESS_TITLE": "Obrisano!",
  "SWAL_DELETE_LANG_SUCCESS_TEXT": "je uspesno obrisan!",
  "SWAL_DELETE_LANG_UNSUCCESS": "Greška! jezik nije obrisan",

  "SIDEBAR_ADVERTISING_TITLE": "Marketing",
  "SIDEBAR_ADVERTISING_TITLE": "Marketing",
  "SIDEBAR_ADVERTISING_SUBMENU_1": "Marketing reklame",
  "SIDEBAR_ADVERTISING_SUBMENU_2": "Marketing vinarije",
  "SIDEBAR_ADVERTISING_SUBMENU_3": "Marketing vina",
  "SIDEBAR_ADVERTISING_SUBMENU_4": "Google ads",
  "ADVERTISING_ADD_EVENT": "Dodaj reklamu",
  
  "ADS_IMAGE": "Slika",
  "ADS TITLE": "Naziv",
  "ADS_START_DATE": "Pocetak",
  "ADS_END_DATE": "Kraj",
  "ADS_ACTIVE": "Aktivna",
  "ADS_EDIT": "Uredi",
  "ADS_DELETE": "Obrisi",
  "ADS_SECTION": "Sekcija",
  "ADS_REPEATING": "Ponavljanje",
  "ADS_ADD_IMAGE": "Dodaj sliku (1080x1920)",
  
  "ADS_WINERY_NAME": "Vinarija",
  "ADS_WINERY_SEARCH": "Pretraga vinarija",
  "ADS_WINERY_LANGUAGE": "Izaberite jezik",
  "ADS_WINERY_ADDRESS": "Adresa",
  "ADS_WINERY_REGION": "Regija",
  "ADS_WINERY_OPTIONS": "Opcije",
  "ADS_WINERY_RECOMMENDED": "Preporuceno",
  "ADS_WINERY_HIGHLIGHTED": "Omiljeno",

  "ADS_WINERY_NOT_RECOMMENDED": "Nije preporuceno",
  "ADS_WINERY_NOT_HIGHLIGHTED": "Nije Istaknuto",
  "ADS_ELEMENTS_PER_PAGE": "Elemenata po stranici",
  "ADS_WINE_NAME": "Naziv",
  "ADS_WINE_SEARCH": "Pretraga vina",
  "ADS_WINE_LANGUAGE": "Izaberite jezik",
  "ADS_WINE_YEAR": "Godina berbe",
  "ADS_WINE_WINERY_NAME": "Ime vinarije",
  "ADS_WINE_OPTIONS": "Opcije",
  "ADS_GOOGLE": "Google ads",
  "CHANGE_PASSWORD_INPUT": "Promeni šifru",

  "WINERY_ADD_MONDAY": "Ponedeljak",
  "WINERY_ADD_TUESDAY": "Utorak",
  "WINERY_ADD_WEDNESDAY": "Sreda",
  "WINERY_ADD_THURSDAY": "Četvrtak",
  "WINERY_ADD_FRIDAY": "Petak",
  "TABLES_WINERY_SEARCH_FIELD_LABEL": "Pretraži vinarije",
  "TABLES_WINE_SEARCH_FIELD_LABEL": "Pretraži vina",
  "TABLES_RESET_FIELDS_BTN_TEXT": "Reset polja",
  "SIDEBAR_COMMENTS_SUBMENU_1": "Komentari vinarija",
  "SIDEBAR_COMMENTS_SUBMENU_2": "Komentari vina",
  "TABLES_USERS_SEARCH_FIELD_LABEL": "Pretraga korisnika",
  "TABLES_ARTICLE_SEARCH_FIELD_LABEL": "Pretraga vesti",
  "TABLES_EVENTS_SEARCH_FIELD_LABEL": "Pretraga dešavanja",
  "RATE_WINE_TABLE_NAME": "Naziv vina",
  "RATE_WINERY_TABLE_NAME": "Naziv vinarije",

  "TABLES_ADS_STATUS_ACTIVATED": "Aktivno",
  "TABLES_ADS_STATUS_DEACTIVATED": "Neaktivno",
  "TABLES_ADS_IMAGE": "Slika",
  "TABLES_ADS_NAME": "Naziv",
  "TABLES_ADS_START_DATE": "Datum početka",
  "TABLES_ADS_END_DATE": "Datum zavrsetka",
  "TABLES_ADS_ACTIVE": "Aktivno",
  "WINE_PATH_ADD_SEARCH_WINERY_LABEL": "Pretraži vinarije iz baze",

  "SETTINGS_CREATE_CARD_NAME": "Kreiranje",
  "SETTINGS_EDIT_CARD_NAME": "Uređivanje",
  "FILES_ALERT_MAX_IMAGE_SIZE_OVERFLOW" : "Veličina slike je prekoračena. Maksimalna dozvoljena veličina slike je 2MB.",
  "FILES_ALERT_MAX_VIDEO_SIZE_OVERFLOW" : "Veličina video zapisa je prekoračena. Maksimalna dozvoljena veličina video zapisa je 35MB.",
  "WINERY_TABLE_REONS" : "Regija",
  "WINERY_TABLE_VINOGORJE" : "Vinogorje",
}';

}
