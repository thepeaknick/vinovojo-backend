<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends BaseModel {

    public static $listData = [
        'id', 'name'
    ];

    protected $hidden = [
        'object_id', 'transliterations'
    ];

    protected $fillable = [
        'name', 'code'
    ];

    public $rules = [
        'name' => 'string|required',
        'code' => 'string|required',


    ];

    public static $transliteratesLists = false;



    //      -- Accessors --

    public function getFlagAttribute() {
        return 17;
    }

    public function getWebFlagAttribute() {
        return 29;
    }

    // public function getNewsFragmentSecondaryTabAttribute($value) {
    //     return explode('#', $value);
    // }

    // public function getWineMainFragmentSecondaryTabAttribute($value) {
    //     return explode('#', $value);
    // }



    //      -- Mutators --

    // public function setNewsFragmentSecondaryTabAttribute($value) {
    //     if (!is_string($value))
    //         $value = implode($value, '#');
    //     $this->attributes['news_fragment_secondary_tab'] = $value;
    // }

    // public function setWineMainFragmentSecondaryTabAttribute($value) {
    //     if (!is_string($value))
    //         $value = implode($value, '#');
    //     $this->attributes['wine_main_fragment_secondary_tab'] = $value;
    // }



    //      --  Relationships --

    public function fields() {
        return $this->hasMany('\App\TextField')->where( 'object_type', (new static)->flag )->where( 'language_id', $this->id );
    }

        
    /**
     * Method mobile
     *
     * object_type for mobile used is 17
     * @return \Illuminate\Database\Eloquent\Relationships\HasMany
     */
    public function mobile() {
        return $this->hasMany('\App\TextField')->where('object_type', $this->flag);
    }

    /**
     * Method web
     *
     * object_type for mobile used is 29
     * @return \Illuminate\Database\Eloquent\Relationships\HasMany
     */
    public function web() {
        return $this->hasMany('\App\TextField')->where('object_type', $this->web_flag);
    }



    //      -- CRUD override --

    public function postCreation($r = null) {
        foreach ($r->mobile as $field => $value) {
            if ( is_array($value) )
                $value = implode('#', $value);

            $txt = new \App\TextField;
            $txt->name = $field;
            $txt->value = $value;
            $txt->object_type = $this->flag;
            $txt->object_id = $this->id;
            $txt->language_id = $this->id;

            if ( !$txt->save() )
                return false;
        }
        if ( $r->has('web') )
            foreach ($r->web as $field => $value) {
                if ( is_array($value) )
                    $value = implode('#', $value);

                $txt = new \App\TextField;
                $txt->name = $field;
                $txt->value = $value;
                $txt->object_type = $this->web_flag;
                $txt->object_id = $this->id;
                $txt->language_id = $this->id;

                if ( !$txt->save() )
                    return false;
            }
        return true;
    }

    public static function list($languageId, $sorting = 'asc', $getQuery = false) {
        $q = static::select(['id', 'name']);
        $q->orderBy( static::$listSort, $sorting );

        return ( $getQuery ) ? $q : $q->get();
    }

    public function singleDisplay($languageId = null) {
        $this->loadMobileFields();

        $fieldNames = array_keys($this->fieldValidation);

        // return $fieldNames;

        return [
            'language' => $this->only(['id', 'name', 'code']),
            'fields' => $this->only( $fieldNames )
        ];
    }

    public function update($r = [], $options = []) {
        if (!parent::update($r, $options))
            return false;

        foreach ($r->fields as $field) {
            \App\TextField::where('id', $field['id'])->update( ['value' => $field['value']] );
        }
        return true;
    }



    //      -- Validation CRUD OVERRIDE --

    public function validatesBeforeCreation() {
        foreach ($this->fieldValidation as $field => $validation)
            $this->rules['mobile.' . $field] = $validation;

        return true;
    }



    //      -- Custom methods --

    public static function getLanguageFromLocale($locale = null) {
        return 1;
        $locale = $locale ?: app()->getLocale();
        $lang = static::where('code', $locale)->select('id')->first();
        return ( is_null($lang) ) ? null : $lang->id;
    }

    public function loadMobileFields() {
        $fields = $this->fields()->whereIn( 'name', array_keys($this->fieldValidation) )->get();
        $fieldNames = $fields->pluck('name')->all();

        $this->fillable = $fieldNames;
        $this->fill( $fields->mapWithKeys( function ($txt) {
            return [
                $txt->name => $txt->value
            ];
        })->all() );

        return $this;
    }
    
    /**
     * Method getMobileFields
     *
     * Loads staitic labels/strings for mobile
     * @return static::only from \App\Model
     */
    public function getMobileFields() {
        $this->loadMobileFields();
        return $this->only( array_keys( $this->fieldValidation ) );
    }

    /**
     * Method loadWebFields
     *
     * Loads staitic labels/strings for web
     * @return static instance
     */
    public function loadWebFields() {
        $fields = $this->web;
        foreach ($fields as $field) {
            $this->{$field->name} = $field->value;
        }
        return $this;
    }

    public function getWebFields() {
        $this->loadWebFields();
        return $this->only( array_keys( $this->webFields ) );
    }

    public function patchInitialize() {
        $this->load('mobile', 'web');
        return $this;
    }


    public static function dropdown($langId = null) {
        return static::select(['id', 'name', 'code'])->get();
    }

    
    /**
     * fieldValidation
     *
     * Used to generate required fields 
     * during patch update translations
     * @var array
     */
    private $fieldValidation = [
        'app_name' => 'required|string',
        'internet_problem' => 'required|string',
        'connect' => 'required|string',
        'no' => 'required|string',
        'error_load_date' => 'required|string',
        'error_load_marker_on_map' => 'required|string',
        'error_no_item_in_wishList' => 'required|string',
        'wishList_wine_message_save' => 'required|string',
        'wishList_wine_message_un_save' => 'required|string',
        'wishList_winery_message_save' => 'required|string',
        'wishList_winery_message_un_save' => 'required|string',
        'news_fragment_secondary_tab_1' => 'required|string',
        'news_fragment_secondary_tab_2' => 'required|string',
        'news_fragment_secondary_tab_3' => 'required|string',
        'wine_main_fragment_secondary_tab_1' => 'required|string',
        'wine_main_fragment_secondary_tab_2' => 'required|string',
        'search_winery' => 'required|string',
        'search_wine' => 'required|string',
        'wine_clear_filter' => 'required|string',
        'events_fragment_save_events_in_calendar' => 'required|string',
        'error_login' => 'required|string',
        'activity_login_screen_message' => 'required|string',
        'activity_login_with_instagram' => 'required|string',
        'activity_login_with_google' => 'required|string',
        'activity_login_with_facebook' => 'required|string',
        'activity_login_text_logout' => 'required|string',
        'title_activity_settings' => 'required|string',
        'fragment_map_open_all_marker' => 'required|string',
        'fragment_map_open_all_region' => 'required|string',
        'error_no_network_connection' => 'required|string',
        'activity_comment_add_comment' => 'required|string',
        'activity_comment_placeholder_comment' => 'required|string',
        'activity_comment_success_add_comment' => 'required|string',
        'profile_menu_toogle_yes' => 'required|string',
        'profile_menu_toogle_no' => 'required|string',
        'activity_login_success_login' => 'required|string',
        'activity_login_success_logout' => 'required|string',
        'working_time_default' => 'required|string',
        'activity_winery_details_region' => 'required|string',
        'fragment_wine_road_toolbar_title' => 'required|string',
        'activity_comment_tollbar_title' => 'required|string',
        'activity_comment_text_rate_wine' => 'required|string',
        'activity_comment_text_add_comment' => 'required|string',
        'activity_comment_text_rate_winery' => 'required|string',
        'activity_comment_text_alert_menu_choose_option_photo' => 'required|string',
        'activity_comment_text_alert_menu_choose_option_photo_message' => 'required|string',
        'activity_comment_text_alert_menu_choose_option_photo_gallery' => 'required|string',
        'activity_comment_text_alert_menu_choose_option_camera' => 'required|string',
        'text_share_title' => 'required|string',
        'activity_login_tour_guide_step_1_title' => 'required|string',
        'activity_login_tour_guide_step_1_message' => 'required|string',
        'activity_login_tour_guide_step_2_title' => 'required|string',
        'activity_login_tour_guide_step_2_message' => 'required|string',
        'activity_login_email_invalid_credentials' => 'required|string',
        'activity_main_side_menu_option_1_language' => 'required|string',
        'activity_main_side_menu_option_2_notification' => 'required|string',
        'activity_main_side_menu_option_3_add_your_wine_path' => 'required|string',
        'activity_main_side_menu_option_4_favorites' => 'required|string',
        'activity_register_alert_toast_message_all_fields_required' => 'required|string',
        'activity_register_alert_toast_message_phone_field_is_required' => 'required|string',
        'activity_register_hint_enter_name' => 'required|string',
        'activity_register_label_name' => 'required|string',
        'activity_register_hint_enter_lastname' => 'required|string',
        'activity_register_label_lastname' => 'required|string',
        'activity_register_next_step' => 'required|string',
        'activity_register_hint_enter_phone' => 'required|string',
        'activity_register_label_phone' => 'required|string',
        'activity_register_hint_enter_email' => 'required|string',
        'activity_register_label_email' => 'required|string',
        'activity_register_hint_enter_password' => 'required|string',
        'activity_register_label_password' => 'required|string',
        'activity_register_final_step_register' => 'required|string',
        'activity_register_success_register' => 'required|string',
        'activity_search_last_seachhing' => 'required|string',
        'activity_search_last_popular' => 'required|string',
        'activity_wine_details_rating_single' => 'required|string',
        'activity_wine_details_rating_multyple' => 'required|string',
        'activity_wine_details_share_message' => 'required|string',
        'activity_wine_details_tour_guide_step_1_title' => 'required|string',
        'activity_wine_details_tour_guide_step_1_message' => 'required|string',
        'activity_wine_details_tour_guide_step_3_title' => 'required|string',
        'activity_wine_details_tour_guide_step_3_message' => 'required|string',
        'activity_wine_details_tour_guide_step_4_title' => 'required|string',
        'activity_wine_details_tour_guide_step_4_message' => 'required|string',
        'activity_wine_details_tour_guide_step_5_title' => 'required|string',
        'activity_wine_details_tour_guide_step_5_message' => 'required|string',
        'activity_winery_details_tour_guide_step_1_title' => 'required|string',
        'activity_winery_details_tour_guide_step_1_message' => 'required|string',
        'activity_winery_details_tour_guide_step_2_title' => 'required|string',
        'activity_winery_details_tour_guide_step_2_message' => 'required|string',
        'activity_winery_details_tour_guide_step_3_title' => 'required|string',
        'activity_winery_details_tour_guide_step_3_message' => 'required|string',
        'activity_winery_details_tour_guide_step_4_title' => 'required|string',
        'activity_winery_details_tour_guide_step_4_message' => 'required|string',
        'activity_winery_details_tour_guide_step_5_title' => 'required|string',
        'activity_winery_details_tour_guide_step_5_message' => 'required|string',
        'activity_winery_details_tour_guide_step_6_title' => 'required|string',
        'activity_winery_details_tour_guide_step_6_message' => 'required|string',
        'wine_view_holder_card_harvast' => 'required|string',
        'activity_language_list_title_toolbar' => 'required|string',
        'activity_login_with_vinovojo' => 'required|string',
        'activity_login_email_label_email' => 'required|string',
        'activity_login_email_label_password' => 'required|string',
        'activity_login_email_hint_email' => 'required|string',
        'activity_login_email_hint_password' => 'required|string',
        'activity_login_email_button_login' => 'required|string',
        'activity_login_email_button_register' => 'required|string',
        'activity_register_textView_profile_image' => 'required|string',
        'activity_register_button_register' => 'required|string',
        'alert_dialog_exit_message' => 'required|string',
        'alert_dialog_exit_negativ_answer' => 'required|string',
        'alert_dialog_exit_positiv_answer' => 'required|string',
        'activity_spalsh_message_first_notification' => 'required|string',
        'activity_wine_details_about_wine' => 'required|string',
        'activity_wine_details_last_comments' => 'required|string',
        'activity_wine_details_all_comments' => 'required|string',
        'activity_wine_details_add_new_comment' => 'required|string',
        'activity_wine_details_share_wine' => 'required|string',
        'activity_wine_details_comment_rate' => 'required|string',
        'activity_wine_details_add_wish_list' => 'required|string',
        'activity_wine_details_attributes_type_wine' => 'required|string',
        'activity_wine_details_attributes_sort_wine' => 'required|string',
        'activity_wine_details_attributes_alcohol' => 'required|string',
        'activity_wine_details_attributes_harvest' => 'required|string',
        'activity_wine_details_attributes_declaration' => 'required|string',
        'activity_winery_details_share_wine' => 'required|string',
        'activity_winery_details_comment_rate' => 'required|string',
        'activity_winery_details_add_wish_list' => 'required|string',
        'activity_winery_details_add_new_comment' => 'required|string',
        'activity_winery_details_all_comments' => 'required|string',
        'activity_winery_details_last_comments' => 'required|string',
        'activity_winery_details_rating_single' => 'required|string',
        'activity_winery_details_rating_multyple' => 'required|string',
        'activity_winery_details_web_site' => 'required|string',
        'activity_winery_details_mob' => 'required|string',
        'item_card_wine_tour_guide_wish_list_wine_title' => 'required|string',
        'item_card_wine_tour_guide_wish_list_wine_message' => 'required|string',
        'item_card_wine_tour_guide_share_title' => 'required|string',
        'item_card_wine_tour_guide_share_message' => 'required|string',
        'item_card_wine_tour_guide_comment_title' => 'required|string',
        'item_card_wine_tour_guide_comment_message' => 'required|string',
        'item_card_wine_tour_guide_title_title' => 'required|string',
        'item_card_wine_tour_guide_title_message' => 'required|string',
        'item_card_winery_tour_guide_wish_list_title' => 'required|string',
        'item_card_winery_tour_guide_wish_list_message' => 'required|string',
        'item_card_winery_tour_guide_share_title' => 'required|string',
        'item_card_winery_tour_guide_share_message' => 'required|string',
        'item_card_winery_tour_guide_comment_title' => 'required|string',
        'item_card_winery_tour_guide_comment_message' => 'required|string',
        'item_card_winery_tour_guide_title_title' => 'required|string',
        'item_card_winery_tour_guide_title_message' => 'required|string',
        'fragment_wine_main_tour_guide_search_title' => 'required|string',
        'fragment_wine_main_tour_guide_search_message' => 'required|string',
        'fragment_wine_main_tour_guide_tab_list_type_wine_title' => 'required|string',
        'fragment_wine_main_tour_guide_tab_list_type_wine_message' => 'required|string',
        'fragment_wine_road_tour_guide_automatic_genrate_path_title' => 'required|string',
        'fragment_wine_road_tour_guide_automatic_genrate_path_message' => 'required|string',
        'fragment_wine_road_tour_guide_go_direction_title' => 'required|string',
        'fragment_wine_road_tour_guide_go_direction_message' => 'required|string',
        'fragment_wine_road_tour_guide_full_height_map_title' => 'required|string',
        'fragment_wine_road_tour_guide_full_height_map_message' => 'required|string',
        'fragment_news_feed_tour_guide_profile_title' => 'required|string',
        'fragment_news_feed_tour_guide_profile_message' => 'required|string',
        'fragment_news_feed_tour_guide_recommended_title' => 'required|string',
        'fragment_news_feed_tour_guide_recommended_message' => 'required|string',
        'fragment_news_feed_no_recommended' => 'required|string',
        'fragment_event_tour_guide_calendar_title' => 'required|string',
        'fragment_event_tour_guide_calendar_message' => 'required|string',
        'fragment_map_marker_not_loaded' => 'required|string',
        'fragment_wish_list_not_favourites' => 'required|string',
        'activity_maps_info_message' => 'required|string',
        'activity_maps_textView_btn_preview_markers' => 'required|string',
        'activity_maps_textView_btn_generate_path' => 'required|string',
        'dialog_wine_filter_winery_in_radius' => 'required|string',
        'dialog_wine_filter_selected_all' => 'required|string',
        'dialog_wine_filter_sorted_none' => 'required|string',
        'dialog_wine_filter_sorted_ascending' => 'required|string',
        'dialog_wine_filter_sorted_descending' => 'required|string',
        'dialog_wine_filter_button_apply' => 'required|string',
        'dialog_wine_filter_button_reset' => 'required|string',
        'dialog_wine_filter_rating_3_and_more' => 'required|string',
        'dialog_wine_filter_region' => 'required|string',
        'dialog_wine_filter_type_wine' => 'required|string',
        'dialog_wine_filter_sort_wine' => 'required|string',
        'dialog_wine_filter_harvest_year' => 'required|string',
        'dialog_wine_filter_winery' => 'required|string',
        'dialog_wine_filter_alcohol' => 'required|string',
        'dialog_wine_filter_sort_with_rating' => 'required|string',
    ];

    private $webFields = [
        'SIDEBAR_USER_SETTTINGS_TITLE' => 'required|string',
        'SIDEBAR_USER_LOGOUT_TILE' => 'required|string',
        'SIDEBAR_CONTROL_BOARD_TITLE' => 'required|string',
        'SIDEBAR_USERS_TITLE' => 'required|string',
        'SIDEBAR_WINERY_TITLE' => 'required|string',
        'SIDEBAR_WINES_TITLE' => 'required|string',
        'SIDEBAR_EVENTS_TITLE' => 'required|string',
        'SIDEBAR_WINE_PATH_TITLE' => 'required|string',
        'SIDEBAR_POINT_OF_INTEREST_TITLE' => 'required|string',
        'SIDEBAR_ARTICLES_TITLE' => 'required|string',
        'SIDEBAR_COMMENTS_TITLE' => 'required|string',
        'SIDEBAR_PUSH_NOTIFICATIONS_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_REGIONS_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_WINE_TYPE_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_WINE_SORT_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_LANGUAGE_TITLE' => 'required|string',
        'SIDEBAR_SETTINGS_CLASSIFICATION_TITLE' => 'required|string',
        'SIDEBAR_ADVERTISING_TITLE' => 'required|string',
        'CONTROL_BOARD_WINERY_CARD_TITLE' => 'required|string',
        'CONTROL_BOARD_WINE_CARD_TITLE' => 'required|string',
        'CONTROL_BOARD_USER_CARD_TITLE' => 'required|string',
        'CONTROL_BOARD_EVENTS_CARD_TITLE' => 'required|string',
        'CONTROL_BOARD_UPDATE_STATUS' => 'required|string',
        'USERS_CARD_NAME' => 'required|string',
        'USERS_TABLE_NAME' => 'required|string',
        'USERS_TABLE_USER_TYPE' => 'required|string',
        'USERS_TABLE_ACTIONS' => 'required|string',
        'USERS_ADD_BUTTON_TITLE' => 'required|string',
        'USERS_DROPDOWN_PLACEHOLDER' => 'required|string',
        'USERS_DROPDOWN_1_ELEMENT' => 'required|string',
        'USERS_DROPDOWN_2_ELEMENT' => 'required|string',
        'USERS_DROPDOWN_3_ELEMENT' => 'required|string',
        'USERS_DROPDOWN_4_ELEMENT' => 'required|string',
        'USERS_DROPDOWN_5_ELEMENT' => 'required|string',
        'USERS_PASSWORD_REQUIREMENTS_LONG_LABEL' => 'required|string',
        'USERS_PASSWORD_REQUIREMENTS_LOW_CASE_LABEL' => 'required|string',
        'USERS_PASSWORD_REQUIREMENTS_UPPER_CASE_LABEL' => 'required|string',
        'USERS_PASSWORD_REQUIREMENTS_NUMBER_LABEL' => 'required|string',
        'USERS_PASSWORD_REQUIREMENTS_SPECIAL_CHAR_LABEL' => 'required|string',
        'USERS_ADD_CARD_NAME' => 'required|string',
        'USERS_ADD_USER_NAME_LABEL' => 'required|string',
        'USERS_ADD_USER_NAME_PLACEHOLDER' => 'required|string',
        'USERS_ADD_USER_EMAIL_LABEL' => 'required|string',
        'USERS_ADD_USER_EMAIL_PLACEHOLDER' => 'required|string',
        'USERS_ADD_USER_PASSWORD_LABEL' => 'required|string',
        'USERS_ADD_USER_PASSWORD_PLACEHOLDER' => 'required|string',
        'USERS_ADD_USER_PASSWORD_CONFIRM_LABEL' => 'required|string',
        'USERS_ADD_USER_PASSWORD_CONFIRM_PLACEHOLDER' => 'required|string',
        'USERS_ADD_TOOLTIP_EYE' => 'required|string',
        'USERS_ADD_USER_SELECT_TYPE_LABEL' => 'required|string',
        'USERS_ADD_USER_SELECT_WINERIES_LABEL' => 'required|string',
        'USERS_ADD_REGISTER_BUTTON_LABEL' => 'required|string',
        'USERS_ADD_BACK_BUTTON_LABEL' => 'required|string',
        'USERS_EDIT_USER_PROFILE' => 'required|string',
        'USERS_EDIT_CARD_NAME' => 'required|string',
        'USERS_EDIT_USER_NAME_LABEL' => 'required|string',
        'USERS_EDIT_USER_NAME_PLACEHOLDER' => 'required|string',
        'USERS_EDIT_USER_EMAIL_LABEL' => 'required|string',
        'USERS_EDIT_USER_EMAIL_PLACEHOLDER' => 'required|string',
        'USERS_EDIT_USER_OLD_PASSWORD_LABEL' => 'required|string',
        'USERS_EDIT_USER_OLD_PASSWORD_PLACEHOLDER' => 'required|string',
        'USERS_EDIT_USER_NEW_PASSWORD_LABEL' => 'required|string',
        'USERS_EDIT_USER_NEW_PASSWORD_PLACEHOLDER' => 'required|string',
        'USERS_EDIT_USER_CONFIRM_NEW_PASSWORD_LABEL' => 'required|string',
        'USERS_EDIT_USER_CONFIRM_NEW_PASSWORD_PLACEHOLDER' => 'required|string',
        'USERS_EDIT_TOOLTIP_EYE' => 'required|string',
        'USERS_EDIT_USER_SELECT_TYPE_LABEL' => 'required|string',
        'USERS_EDIT_USER_SELECT_WINERIES_LABEL' => 'required|string',
        'USERS_EDIT_REGISTER_BUTTON_LABEL' => 'required|string',
        'USERS_EDIT_BACK_BUTTON_LABEL' => 'required|string',
        'USERS_EDIT_ADDITIONAL_TIPS' => 'required|string',
        'USERS_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'USERS_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'USERS_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'USERS_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'USERS_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'USERS_ALERT_MSG_CHANGE_TYPE_SUCCESS' => 'required|string',
        'USERS_ALERT_MSG_SUCCESS_CREATE' => 'required|string',
        'USERS_ALERT_MSG_SUCCESS_PATCH' => 'required|string',
        'USERS_ALERT_MSG_WRONG_PASSWORD' => 'required|string',
        'USERS_ALERT_MSG_ERROR_PASSWORD_LENGTH' => 'required|string',
        'USERS_ALERT_MSG_ERROR_EMAIL' => 'required|string',
        'WINERY_CARD_NAME' => 'required|string',
        'WINERY_TABLE_NAME' => 'required|string',
        'WINERY_TABLE_ADDRESS' => 'required|string',
        'WINERY_TABLE_REGION' => 'required|string',
        'WINERY_TABLE_OPTIONS' => 'required|string',
        'WINERY_TABLE_ACTIONS' => 'required|string',
        'WINERY_TABLE_ALERT_MSG_DEACTIVATE' => 'required|string',
        'WINERY_TABLE_ALERT_MSG_ACTIVATE' => 'required|string',
        'WINERY_ADD_CARD_NAME' => 'required|string',
        'WINERY_ADD_WINERY_NAME_LABEL' => 'required|string',
        'WINERY_ADD_WINERY_NAME_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_WINERY_DESC_LABEL' => 'required|string',
        'WINERY_ADD_WINERY_DESC_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_WORKING_HOURS_LABEL' => 'required|string',
        'WINERY_ADD_MONDAY_FIRDAY' => 'required|string',
        'WINERY_ADD_SATURDAY' => 'required|string',
        'WINERY_ADD_SUNDAY' => 'required|string',
        'WINERY_ADD_START_HOURS_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_END_HOURS_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_RECOMMENDED_LABEL' => 'required|string',
        'WINERY_ADD_HIGHLIGHTED_LABEL' => 'required|string',
        'WINERY_ADD_REGION_LIST_LABEL' => 'required|string',
        'WINERY_ADD_REON_LIST_LABEL' => 'required|string',
        'WINERY_ADD_VINOGORJE_LIST_LABEL' => 'required|string',
        'WINERY_ADD_PHONE_NO_LABEL' => 'required|string',
        'WINERY_ADD_PHONE_NO_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_PHONE_PATTERN_ERROR' => 'required|string',
        'WINERY_ADD_PHONE_CONTACT_LABEL' => 'required|string',
        'WINERY_ADD_PHONE_CONTACT_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_WEB_PAGE_LABEL' => 'required|string',
        'WINERY_ADD_SELECT_WINERY_ADMIN_LABEL' => 'required|string',
        'WINERY_ADD_WEB_PAGE_PLACEHOLDER' => 'required|string',
        'WINERY_ADD_LOCATION_CARD_TITLE' => 'required|string',
        'WINERY_ADD_WINERY_ADDRESS' => 'required|string',
        'WINERY_ADD_LOCATION_TIPS' => 'required|string',
        'WINERY_ADD_GALLERY_CARD_TITLE' => 'required|string',
        'WINERY_ADD_ADD_BUTTON_TITLE' => 'required|string',
        'WINERY_EDIT_CARD_NAME' => 'required|string',
        'WINERY_EDIT_WINERY_NAME_LABEL' => 'required|string',
        'WINERY_EDIT_WINERY_DESC_LABEL' => 'required|string',
        'WINERY_EDIT_WINERY_DESC_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_WORKING_HOURS_LABEL' => 'required|string',
        'WINERY_EDIT_MONDAY_FRIDAY' => 'required|string',
        'WINERY_EDIT_MONDAY_FRIDAY_NOT_WORKING' => 'required|string',
        'WINERY_EDIT_SATURDAY' => 'required|string',
        'WINERY_EDIT_SATURDAY_NOT_WORKING' => 'required|string',
        'WINERY_EDIT_SUNDAY' => 'required|string',
        'WINERY_EDIT_SUNDAY_NOT_WORKING' => 'required|string',
        'WINERY_EDIT_START_HOURS_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_END_HOURS_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_RECOMMENDED_LABEL' => 'required|string',
        'WINERY_EDIT_HIGHLIGHTED_LABEL' => 'required|string',
        'WINERY_EDIT_REGION_LIST_LABEL' => 'required|string',
        'WINERY_EDIT_REON_LIST_LABEL' => 'required|string',
        'WINERY_EDIT_VINOGORJE_LIST_LABEL' => 'required|string',
        'WINERY_EDIT_PHONE_NO_LABEL' => 'required|string',
        'WINERY_EDIT_PHONE_NO_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_PHONE_CONTACT_LABEL' => 'required|string',
        'WINERY_EDIT_PHONE_CONTACT_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_WEB_PAGE_LABEL' => 'required|string',
        'WINERY_EDIT_SELECT_WINERY_ADMIN_LABEL' => 'required|string',
        'WINERY_EDIT_WEB_PAGE_PLACEHOLDER' => 'required|string',
        'WINERY_EDIT_LOCATION_CARD_TITLE' => 'required|string',
        'WINERY_EDIT_WINERY_ADDRESS' => 'required|string',
        'WINERY_EDIT_LOCATION_TIPS' => 'required|string',
        'WINERY_EDIT_GALLERY_CARD_TITLE' => 'required|string',
        'WINERY_EDIT_ADD_BUTTON_TITLE' => 'required|string',
        'WINERY_EDIT_CANCEL_TIME_TOOLTIP' => 'required|string',
        'WINERY_PREVIEW_CARD_NAME' => 'required|string',
        'WINERY_PREVIEW_WINERY_NAME_LABEL' => 'required|string',
        'WINERY_PREVIEW_WINERY_DESC_LABEL' => 'required|string',
        'WINERY_PREVIEW_LANG_TITLE' => 'required|string',
        'WINERY_PREVIEW_RECOMMENDED_TITLE' => 'required|string',
        'WINERY_PREVIEW_YES' => 'required|string',
        'WINERY_PREVIEW_NO' => 'required|string',
        'WINERY_PREVIEW_ADDRESS_TITLE' => 'required|string',
        'WINERY_PREVIEW_WEB_PAGE_TITLE' => 'required|string',
        'WINERY_PREVIEW_NO_LINK' => 'required|string',
        'WINERY_PREVIEW_WORKING_HOURS_TITLE' => 'required|string',
        'WINERY_PREVIEW_MONDAY_FRIDAY' => 'required|string',
        'WINERY_PREVIEW_SATURDAY' => 'required|string',
        'WINERY_PREVIEW_SUNDAY' => 'required|string',
        'WINERY_PREVIEW_NOT_WORKING' => 'required|string',
        'WINERY_PREVIEW_CONTACT' => 'required|string',
        'WINERY_PREVIEW_AVG_RATE' => 'required|string',
        'WINERY_PREVIEW_REGION_TITLE' => 'required|string',
        'WINERY_PREVIEW_REON_TITLE' => 'required|string',
        'WINERY_PREVIEW_VINOGORJE_TITLE' => 'required|string',
        'WINERY_PREVIEW_WINE_CATEGORIES' => 'required|string',
        'WINERY_PRIVIEW_WINE_CATEGORIES_NO_RESULTS' => 'required|string',
        'WINERY_PREVIEW_LOCATION_ON_MAP_TITLE' => 'required|string',
        'WINERY_PREVIEW_CREATE_AT_TITLE' => 'required|string',
        'WINERY_PREVIEW_UPDATE_AT_TITLE' => 'required|string',
        'WINERY_PREVIEW_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINERY_PREVIEW_COMMENT_BUTTON_TOOLTIP' => 'required|string',
        'WINERY_ALERT_MSG_MONDAY_FRIDAY_NOT_VALID' => 'required|string',
        'WINERY_ALERT_MSG_SATURDAY_NOT_VALID' => 'required|string',
        'WINERY_ALERT_MSG_SUNDAY_NOT_VALID' => 'required|string',
        'WINERY_ALERT_MSG_SUCCESS_CREATE' => 'required|string',
        'WINERY_ALERT_MSG_UNSUCCESS_CREATE' => 'required|string',
        'WINERY_ALERT_MSG_IMAGE_REMOVE_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_IMAGE_REMOVE_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_IMAGE_REMOVE_SUCCESS_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_IMAGE_REMOVE_SUCCESS_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_IMAGE_REMOVE_UNSUCCESS' => 'required|string',
        'WINERY_ALERT_MSG_VIDEO_REMOVE_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_VIDEO_REMOVE_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_VIDEO_REMOVE_SUCCESS_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_VIDEO_REMOVE_SUCCESS_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_VIDEO_REMOVE_UNSUCCESS' => 'required|string',
        'WINERY_ALERT_MSG_SAVE_LANG_ALERT' => 'required|string',
        'WINERY_ALERT_MSG_FALSE_FILE' => 'required|string',
        'WINERY_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINERY_ALERT_MSG_GALLERY_IMAGE_ERR' => 'required|string',
        'WINERY_ALERT_MSG_NOT_VALID_UPLOADED_FILES' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_SUCCESS_TITLE' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_SUCCESS_TEXT' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_UNSUCCESS_PART1' => 'required|string',
        'WINERY_ALERT_MSG_TABLE_ALERTS_DELETE_WINERY_UNSUCCESS_PART2' => 'required|string',
        'WINES_CARD_NAME' => 'required|string',
        'WINES_TABLE_NAME' => 'required|string',
        'WINES_TABLE_HARVEST_YEAR' => 'required|string',
        'WINES_TABLE_WINERY_NAME' => 'required|string',
        'WINES_TABLE_OPTIONS' => 'required|string',
        'WINES_TABLE_ACTIONS' => 'required|string',
        'WINES_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINES_TABLE_ALERT_MSG_DEACTIVATE' => 'required|string',
        'WINES_TABLE_ALERT_MSG_ACTIVATE' => 'required|string',
        'WINES_ADD_CARD_NAME' => 'required|string',
        'WINES_ADD_WINE_NAME' => 'required|string',
        'WINES_ADD_WINE_NAME_PLACEHOLDER' => 'required|string',
        'WINES_ADD_WINE_DESC' => 'required|string',
        'WINES_ADD_WINE_DESC_PLACEHOLDER' => 'required|string',
        'WINES_ADD_WINE_REQUIREMENTS_MSG_BACKGROUND_IMAGE' => 'required|string',
        'WINES_ADD_WINE_REQUIREMENTS_MSG_FORMAT_IMAGE' => 'required|string',
        'WINES_ADD_WINE_REQUIREMENTS_MSG_RESOLUTION_IMAGE' => 'required|string',
        'WINES_ADD_IMAGE_BACKGROUND_YES' => 'required|string',
        'WINES_ADD_IMAGE_BACKGROUND_NO' => 'required|string',
        'WINES_ADD_RECOMMENDED_LABEL' => 'required|string',
        'WINES_ADD_HIGHLIGHTED_LABEL' => 'required|string',
        'WINES_ADD_WINE_SORT_LABEL' => 'required|string',
        'WINES_ADD_CLASSIFICATION_LABEL' => 'required|string',
        'WINES_ADD_WINE_CATEGORY_LABEL' => 'required|string',
        'WINES_ADD_WINERY_LABEL' => 'required|string',
        'WINES_ADD_REGION_LIST_LABEL' => 'required|string',
        'WINES_ADD_REON_LIST_LABEL' => 'required|string',
        'WINES_ADD_VINOGORJE_LIST_LABEL' => 'required|string',
        'WINES_ADD_HARVEST_YEAR_LABEL' => 'required|string',
        'WINES_ADD_HARVEST_YEAR_PLACEHOLDER' => 'required|string',
        'WINES_ADD_ALCOHOL_LABEL' => 'required|string',
        'WINES_ADD_ALCOHOL_PLACEHOLDER' => 'required|string',
        'WINES_ADD_TEMP_SERVING_LABEL' => 'required|string',
        'WINES_ADD_TEMP_SERVING_PLACEHOLDER' => 'required|string',
        'WINES_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINES_EDIT_CARD_NAME' => 'required|string',
        'WINES_EDIT_WINE_NAME' => 'required|string',
        'WINES_EDIT_WINE_NAME_PLACEHOLDER' => 'required|string',
        'WINES_EDIT_WINE_DESC' => 'required|string',
        'WINES_EDIT_WINE_DESC_PLACEHOLDER' => 'required|string',
        'WINES_EDIT_WINE_REQUIREMENTS_MSG_BACKGROUND_IMAGE' => 'required|string',
        'WINES_EDIT_WINE_REQUIREMENTS_MSG_FORMAT_IMAGE' => 'required|string',
        'WINES_EDIT_WINE_REQUIREMENTS_MSG_RESOLUTION_IMAGE' => 'required|string',
        'WINES_EDIT_IMAGE_BACKGROUND_YES' => 'required|string',
        'WINES_EDIT_IMAGE_BACKGROUND_NO' => 'required|string',
        'WINES_EDIT_RECOMMENDED_LABEL' => 'required|string',
        'WINES_EDIT_HIGHLIGHTED_LABEL' => 'required|string',
        'WINES_EDIT_WINE_SORT_LABEL' => 'required|string',
        'WINES_EDIT_CLASSIFICATION_LABEL' => 'required|string',
        'WINES_EDIT_WINE_CATEGORY_LABLE' => 'required|string',
        'WINES_EDIT_WINERY_LABEL' => 'required|string',
        'WINES_EDIT_REGION_LIST_LABEL' => 'required|string',
        'WINES_EDIT_REON_LIST_LABEL' => 'required|string',
        'WINES_EDIT_VINOGORJE_LIST_LABEL' => 'required|string',
        'WINES_EDIT_HARVEST_YEAR_LABEL' => 'required|string',
        'WINES_EDIT_HARVEST_YEAR_PLACEHOLDER' => 'required|string',
        'WINES_EDIT_ALCOHOL_LABEL' => 'required|string',
        'WINES_EDIT_ALCOHOL_PLACEHOLDER' => 'required|string',
        'WINES_EDIT_TEMP_SERVING_LABEL' => 'required|string',
        'WINES_EDIT_TEMP_SERVING_PLACEHOLDER' => 'required|string',
        'WINES_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_PREVIEW_CARD_NAME' => 'required|string',
        'WINE_PREVIEW_WINE_NAME' => 'required|string',
        'WINE_PREVIEW_WINE_DESC' => 'required|string',
        'WINE_PREVIEW_RECOMMENDED_LABEL' => 'required|string',
        'WINE_PREVIEW_YES' => 'required|string',
        'WINE_PREVIEW_NO' => 'required|string',
        'WINE_PREVIEW_WINE_SORT_LABEL' => 'required|string',
        'WINE_PREVIEW_REGION_LABEL' => 'required|string',
        'WINE_PREVIEW_REON_LABEL' => 'required|string',
        'WINE_PREVIEW_VINOGORJE_LABEL' => 'required|string',
        'WINE_PREVIEW_WINE_CATEGORY_LABEL' => 'required|string',
        'WINE_PREVIEW_WINERY_NAME_LABEL' => 'required|string',
        'WINE_PREVIEW_AVG_RATE_LABEL' => 'required|string',
        'WINE_PREVIEW_CREATE_AT_LABEL' => 'required|string',
        'WINE_PREVIEW_UPDATE_AT_LABEL' => 'required|string',
        'WINE_PREVIEW_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_PREVIEW_COMMENT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_ALERT_MSG_SUCCESS_CREATE' => 'required|string',
        'WINE_ALERT_MSG_UNSUCCESS_CREATE' => 'required|string',
        'WINE_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINE_ALERT_MSG_UNSUCCESS_EDITED' => 'required|string',
        'WINE_ALERT_MSG_SUBMIT_INVALID_IMAGE' => 'required|string',
        'WINE_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'WINE_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'WINE_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'WINE_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'WINE_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'EVENTS_CARD_NAME' => 'required|string',
        'EVENTS_TABLE_NAME' => 'required|string',
        'EVENTS_TABLE_START_DATE' => 'required|string',
        'EVENTS_TABLE_END_DATE' => 'required|string',
        'EVENTS_TABLE_LOCATION' => 'required|string',
        'EVENTS_TABLE_ACTIONS' => 'required|string',
        'EVENTS_ADD_BUTTON_TOOLTIP' => 'required|string',
        'EVENTS_ADD_CARD_NAME' => 'required|string',
        'EVENTS_ADD_EVENTS_NAME' => 'required|string',
        'EVENTS_ADD_EVENTS_NAME_PLACEHOLDER' => 'required|string',
        'EVENTS_ADD_EVENTS_DESC' => 'required|string',
        'EVENTS_ADD_EVENTS_DESC_PLACEHOLDER' => 'required|string',
        'EVENTS_ADD_RADIO_BUTTON_LINK' => 'required|string',
        'EVENTS_ADD_RADIO_BUTTON_DESC' => 'required|string',
        'EVENTS_ADD_EVENTS_START_DATE_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_START_DATE_PLACEHOLDER' => 'required|string',
        'EVENTS_ADD_EVENTS_START_TIME_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_END_DATE_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_END_DATE_PLACEHOLDER' => 'required|string',
        'EVENTS_ADD_EVENTS_END_TIME_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_LINK_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_LINK_PLACEHOLDER' => 'required|string',
        'EVENTS_ADD_EVENTS_LOCATION_CARD_NAME' => 'required|string',
        'EVENTS_ADD_EVENTS_ADDRESS_LABEL' => 'required|string',
        'EVENTS_ADD_EVENTS_ADDRESS_PLACHOLDER' => 'required|string',
        'EVENTS_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'EVENTS_ADD_LOCATION_TIPS' => 'required|string',
        'EVENTS_EDIT_CARD_NAME' => 'required|string',
        'EVENTS_EDIT_EVENTS_NAME' => 'required|string',
        'EVENTS_EDIT_EVENTS_NAME_PLACEHOLDER' => 'required|string',
        'EVENTS_EDIT_EVENTS_DESC' => 'required|string',
        'EVENTS_EDIT_EVENTS_DESC_PLACEHOLDER' => 'required|string',
        'EVENTS_EDIT_RADIO_BUTTON_LINK' => 'required|string',
        'EVENTS_EDIT_RADIO_BUTTON_DESC' => 'required|string',
        'EVENTS_EDIT_EVENTS_START_DATE_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_START_DATE_PLACEHOLDER' => 'required|string',
        'EVENTS_EDIT_EVENTS_START_TIME_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_END_DATE_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_END_DATE_PLACEHOLDER' => 'required|string',
        'EVENTS_EDIT_EVENTS_END_TIME_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_LINK_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_LINK_PLACEHOLDER' => 'required|string',
        'EVENTS_EDIT_EVENTS_LOCATION_CARD_NAME' => 'required|string',
        'EVENTS_EDIT_EVENTS_ADDRESS_LABEL' => 'required|string',
        'EVENTS_EDIT_EVENTS_ADDRESS_PLACHOLDER' => 'required|string',
        'EVENTS_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'EVENTS_EDIT_LOCATION_TIPS' => 'required|string',
        'EVENTS_REVIEW_CARD_NAME' => 'required|string',
        'EVENTS_REVIEW_EVENTS_NAME' => 'required|string',
        'EVENTS_REVIEW_EVENTS_DESC' => 'required|string',
        'EVENTS_REVIEW_START_DATE_TIME_LABEL' => 'required|string',
        'EVENTS_REVIEW_END_DATE_TIME_LABEL' => 'required|string',
        'EVENTS_REVIEW_LOCATION_LABEL' => 'required|string',
        'EVENTS_REVIEW_LINK_LABEL' => 'required|string',
        'EVENTS_REVIEW_CREATED_AT_LABEL' => 'required|string',
        'EVENTS_REVIEW_UPDATED_AT_LABEL' => 'required|string',
        'EVENTS_REVIEW_MAP_LOCATION_TITLE' => 'required|string',
        'EVENTS_REVIEW_BUTTON_TOOLTIP' => 'required|string',
        'EVENTS_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'EVENTS_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'EVENTS_ALERT_MSG_UNSUCCESS' => 'required|string',
        'EVENTS_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'EVENTS_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'EVENTS_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'EVENTS_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'EVENTS_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'WINE_PATH_SEARCH_LABEL' => 'required|string',
        'WINE_PATH_SEARCH_PLACEHOLDER' => 'required|string',
        'WINE_PATH_LANG_LABEL' => 'required|string',
        'WINE_PATH_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_NAME' => 'required|string',
        'WINE_PATH_ADD_LANG_NAME_TITLE' => 'required|string',
        'WINE_PATH_ADD_SEARCH_POI_LABEL' => 'required|string',
        'WINE_PATH_ADD_SEARCH_POI_PLACEHOLDER' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_MAP_TITLE' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_MAP_TIP' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_MAP_TIP2' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_POI_NAME_LABEL' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_ADDRESS_LABEL' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_TYPE_LABEL' => 'required|string',
        'WINE_PATH_ADD_WINE_PATH_REMOVE_POI_TOOLTIP' => 'required|string',
        'WINE_PATH_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_NAME' => 'required|string',
        'WINE_PATH_EDIT_LANG_NAME_TITLE' => 'required|string',
        'WINE_PATH_EDIT_SEARCH_POI_LABEL' => 'required|string',
        'WINE_PATH_EDIT_SEARCH_POI_PLACEHOLDER' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_MAP_TITLE' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_MAP_TIP' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_MAP_TIP2' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_POI_NAME_LABEL' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_POI_NAME_PLACEHOLDER' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_ADDRESS_LABEL' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_ADDRESS_PLACEHOLDER' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_TYPE_LABEL' => 'required|string',
        'WINE_PATH_EDIT_WINE_PATH_REMOVE_POI_TOOLTIP' => 'required|string',
        'WINE_PATH_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_PATH_ALERT_MSG_MIN_MARKERS_ERR' => 'required|string',
        'WINE_PATH_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'WINE_PATH_ALERT_MSG_WINDOWS_ALERT_MAX_NO_POINTS' => 'required|string',
        'WINE_PATH_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINE_PATH_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'WINE_PATH_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'WINE_PATH_ALERT_MSG_CANNOT_ADD_MARKER' => 'required|string',
        'WINE_PATH_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'WINE_PATH_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'POI_CARD_NAME' => 'required|string',
        'POI_SEARCH_LABEL' => 'required|string',
        'POI_ADD_BUTTON_TOOLTIP' => 'required|string',
        'POI_TABLE_NAME' => 'required|string',
        'POI_TABLE_ADDRESS' => 'required|string',
        'POI_TABLE_TYPE' => 'required|string',
        'POI_TABLE_ACTIONS' => 'required|string',
        'POI_ADD_POI_NAME' => 'required|string',
        'POI_ADD_LANG_NAME_TITLE' => 'required|string',
        'POI_ADD_POI_ADDRESS_LABEL' => 'required|string',
        'POI_ADD_POI_TYPE_LABEL' => 'required|string',
        'POI_ADD_POI_MAP_TITLE' => 'required|string',
        'POI_ADD_POI_MAP_TIP' => 'required|string',
        'POI_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'POI_ADD_MODAL_MSG' => 'required|string',
        'POI_EDIT_POI_NAME' => 'required|string',
        'POI_EDIT_LANG_NAME_TITLE' => 'required|string',
        'POI_EDIT_POI_ADDRESS_LABEL' => 'required|string',
        'POI_EDIT_POI_TYPE_LABEL' => 'required|string',
        'POI_EDIT_POI_MAP_TITLE' => 'required|string',
        'POI_EDIT_POI_MAP_TIP' => 'required|string',
        'POI_EDIT_ADD_BUTTON_TOOLTIP' => 'required|string',
        'POI_EDIT_MODAL_MSG' => 'required|string',
        'POI_ALERT_MSG_MARKER_ERR' => 'required|string',
        'POI_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'POI_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'POI_ALERT_MSG_CANNOT_ADD_MARKER' => 'required|string',
        'POI_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'POI_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'POI_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'POI_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'ARTICLES_CARD_NAME' => 'required|string',
        'ARTICLES_TABLE_CREATED' => 'required|string',
        'ARTICLES_TABLE_NAME' => 'required|string',
        'ARTICLES_TABLE_TEXT' => 'required|string',
        'ARTICLES_TABLE_LINK' => 'required|string',
        'ARTICLES_TABLE_ACTIONS' => 'required|string',
        'ARTICLES_ADD_BUTTON_TOOLTIP' => 'required|string',
        'ARTICLES_ADD_CARD_NAME' => 'required|string',
        'ARTICLES_ADD_ARTICLES_NAME_LABEL' => 'required|string',
        'ARTICLES_ADD_ARTICLES_NAME_PLACEHOLDER' => 'required|string',
        'ARTICLES_ADD_ARTICLES_TEXT_LABEL' => 'required|string',
        'ARTICLES_ADD_ARTICLES_TEXT_PLACEHOLDER' => 'required|string',
        'ARTICLES_ADD_DISABLE_CHECKBOX_LABEL' => 'required|string',
        'ARTICLES_ADD_ARTICLES_LINK_LABEL' => 'required|string',
        'ARTICLES_ADD_ARTICLES_LINK_PLACEHOLDER' => 'required|string',
        'ARTICLES_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'ARTICLES_EDIT_CARD_NAME' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_NAME_LABEL' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_NAME_PLACEHOLDER' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_TEXT_LABEL' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_TEXT_PLACEHOLDER' => 'required|string',
        'ARTICLES_EDIT_DISABLE_CHECKBOX_LABEL' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_LINK_LABEL' => 'required|string',
        'ARTICLES_EDIT_ARTICLES_LINK_PLACEHOLDER' => 'required|string',
        'ARTICLES_EDIT_ADD_BUTTON_TOOLTIP' => 'required|string',
        'ARTICLES_REVIEW_MODAL_CARD_NAME' => 'required|string',
        'ARTICLES_REVIEW_MODAL_TITLE' => 'required|string',
        'ARTICLES_REVIEW_MODAL_TEXT' => 'required|string',
        'ARTICLES_REVIEW_MODAL_IMAGE' => 'required|string',
        'ARTICLES_REVIEW_MODAL_LINK' => 'required|string',
        'ARTICLES_REVIEW_MODAL_CREATED_AT' => 'required|string',
        'ARTICLES_REVIEW_BUTTON_LABEL' => 'required|string',
        'ARTICLES_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'ARTICLES_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'ARTICLES_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'ARTICLES_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'ARTICLES_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'ARTICLES_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'ARTICLES_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'ARTICLES_ALERT_MSG_IMAGE_INVALID' => 'required|string',
        'RATE_CARD_NAME' => 'required|string',
        'RATE_TABLE_CREATED' => 'required|string',
        'RATE_TABLE_USER_NAME' => 'required|string',
        'RATE_TABLE_COMMENT' => 'required|string',
        'RATE_TABLE_RATE' => 'required|string',
        'RATE_TABLE_STATUS' => 'required|string',
        'RATE_TABLE_DELETE' => 'required|string',
        'RATE_SELECT_SECTION_LABEL' => 'required|string',
        'RATE_SELECT_WINE_LABEL' => 'required|string',
        'RATE_SELECT_WINERY_LABEL' => 'required|string',
        'RATE_SELECT_FILTER_LABEL' => 'required|string',
        'RATE_SELECT_FILTER_ALL' => 'required|string',
        'RATE_SELECT_FILTER_APPROVED' => 'required|string',
        'RATE_SELECT_FILTER_DEAPPROVED' => 'required|string',
        'RATE_SELECT_FILTER_HOLD' => 'required|string',
        'RATE_PREVIEW_MODAL_CARD_NAME' => 'required|string',
        'RATE_PREVIEW_MODAL_STATUS' => 'required|string',
        'RATE_PREVIEW_MODAL_STATUS_LABELS_APPROVED' => 'required|string',
        'RATE_PREVIEW_MODAL_STATUS_LABELS_DEAPPROVED' => 'required|string',
        'RATE_PREVIEW_MODAL_STATUS_LABELS_HOLD' => 'required|string',
        'RATE_PREVIEW_MODAL_NAME' => 'required|string',
        'RATE_PREVIEW_MODAL_COMMENT' => 'required|string',
        'RATE_PREVIEW_MODAL_CREATED' => 'required|string',
        'RATE_PREVIEW_MODAL_RATE' => 'required|string',
        'RATE_PREVIEW_MODAL_APPROVE_BUTTON_LABEL' => 'required|string',
        'RATE_PREVIEW_MODAL_DEAPPROVED_BUTTON_LABEL' => 'required|string',
        'RATE_PREVIEW_MODAL_IMAGE' => 'required|string',
        'RATE_ALERT_MSG_DELETE_RATE_TITLE' => 'required|string',
        'RATE_ALERT_MSG_DELETE_RATE_TEXT' => 'required|string',
        'RATE_ALERT_MSG_DELETE_RATE_SUCCESS_TITLE' => 'required|string',
        'RATE_ALERT_MSG_DELETE_RATE_SUCCESS_TEXT' => 'required|string',
        'RATE_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'RATE_ALERT_MSG_DEAPPROVED_TITLE' => 'required|string',
        'RATE_ALERT_MSG_DEAPPROVED' => 'required|string',
        'RATE_ALERT_MSG_APPROVED_TITLE' => 'required|string',
        'RATE_ALERT_MSG_APPROVED' => 'required|string',
        'PUSH_NOTIFICATIONS_CARD_NAME' => 'required|string',
        'PUSH_NOTIFICATIONS_TITLE' => 'required|string',
        'PUSH_NOTIFICATIONS_TITLE_PLACEHOLDER' => 'required|string',
        'PUSH_NOTIFICATIONS_TEXT' => 'required|string',
        'PUSH_NOTIFICATIONS_TEXT_PLACEHOLDER' => 'required|string',
        'PUSH_NOTIFICATIONS_CHECKBOX_LABEL' => 'required|string',
        'PUSH_NOTIFICATIONS_SELECT_LABEL' => 'required|string',
        'PUSH_NOTIFICATIONS_SEND_BUTTON_LABEL' => 'required|string',
        'PUSH_ALERT_MSG_SUCCES_CREATED' => 'required|string',
        'REGIONS_REGIONS_CARD_NAME' => 'required|string',
        'REGIONS_REONS_CARD_NAME' => 'required|string',
        'REGIONS_VINOGORJE_CARD_NAME' => 'required|string',
        'REGIONS_TABLE_NAME' => 'required|string',
        'REGIONS_TABLE_ACTIONS' => 'required|string',
        'REGIONS_ADD_BUTTON_TOOLTIP' => 'required|string',
        'REGIONS_ADD_BUTTON_REGION' => 'required|string',
        'REGIONS_ADD_BUTTON_REON' => 'required|string',
        'REGIONS_ADD_BUTTON_VINOGORJE' => 'required|string',
        'REGIONS_REGIONS_CREATE_CARD_NAME' => 'required|string',
        'REGIONS_REONS_CREATE_CARD_NAME' => 'required|string',
        'REGIONS_VINOGORJE_CREATE_CARD_NAME' => 'required|string',
        'REGIONS_ADD_CARD_NAME' => 'required|string',
        'REGIONS_ADD_REGION_LIST' => 'required|string',
        'REGIONS_ADD_REON_LIST' => 'required|string',
        'REGIONS_ADD_REGION_NAME' => 'required|string',
        'REGIONS_ADD_REGION_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_REGION_DESC' => 'required|string',
        'REGIONS_ADD_REGION_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_REON_NAME' => 'required|string',
        'REGIONS_ADD_REON_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_REON_DESC' => 'required|string',
        'REGIONS_ADD_REON_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_VINOGORJA_NAME' => 'required|string',
        'REGIONS_ADD_VINOGORJA_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_VINOGORJA_DESC' => 'required|string',
        'REGIONS_ADD_VINOGORJA_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_ADD_POLYGON_CARD_NAME' => 'required|string',
        'REGIONS_ADD_MAP_TITLE' => 'required|string',
        'REGIONS_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'REGIONS_EDIT_CARD_NAME' => 'required|string',
        'REGIONS_EDIT_REGION_LIST' => 'required|string',
        'REGIONS_EDIT_REON_LIST' => 'required|string',
        'REGIONS_EDIT_REGION_NAME' => 'required|string',
        'REGIONS_EDIT_REGION_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_REGION_DESC' => 'required|string',
        'REGIONS_EDIT_REGION_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_REON_NAME' => 'required|string',
        'REGIONS_EDIT_REON_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_REON_DESC' => 'required|string',
        'REGIONS_EDIT_REON_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_VINOGORJA_NAME' => 'required|string',
        'REGIONS_EDIT_VINOGORJA_NAME_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_VINOGORJA_DESC' => 'required|string',
        'REGIONS_EDIT_VINOGORJA_DESC_PLACEHOLDER' => 'required|string',
        'REGIONS_EDIT_POLYGON_CARD_NAME' => 'required|string',
        'REGIONS_EDIT_MAP_TITLE' => 'required|string',
        'REGIONS_EDIT_ADD_BUTTON_TOOLTIP' => 'required|string',
        'REGIONS_ALERT_MSG_POLYGON_PATTERN' => 'required|string',
        'REGIONS_ALERT_MSG_WINDOWS_ALERT' => 'required|string',
        'REGIONS_ALERT_MSG_SUCCESS_CREATE' => 'required|string',
        'REGIONS_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'REGIONS_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'REGIONS_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'REGIONS_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'REGIONS_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'REGIONS_ALERT_MSG_NOT_ALLOWED_DELETE_REGIONS' => 'required|string',
        'REGIONS_ALERT_MSG_NOT_ALLOWED_DELETE_REONS' => 'required|string',
        'REGIONS_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'USERS_DROPDOWN_5_ELEMENT'=>'required|string',
        'WINE_CATEGORIES_CARD_NAME' => 'required|string',
        'WINE_CATEGORIES_TABLE_NAME' => 'required|string',
        'WINE_CATEGORIES_TABLE_ACTIONS' => 'required|string',
        'WINE_CATEGORIES_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_CATEGORIES_ADD_WINE_CATEGORIES_NAME' => 'required|string',
        'WINE_CATEGORIES_ADD_WINE_CATEGORIES_NAME_PLACEHOLDER' => 'required|string',
        'WINE_CATEGORIES_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_CATEGORIES_EDIT_WINE_CATEGORIES_NAME' => 'required|string',
        'WINE_CATEGORIES_EDIT_WINE_CATEGORIES_NAME_PLACEHOLDER' => 'required|string',
        'WINE_CATEGORIES_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'WINE_CATEGORIES_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'WINE_TYPE_CARD_NAME' => 'required|string',
        'WINE_TYPE_TABLE_NAME' => 'required|string',
        'WINE_TYPE_TABLE_DESC' => 'required|string',
        'WINE_TYPE_TABLE_ACTIONS' => 'required|string',
        'WINE_TYPE_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_TYPE_ADD_WINE_TYPE_NAME_LABEL' => 'required|string',
        'WINE_TYPE_ADD_WINE_TYPE_NAME_PLACEHOLDER' => 'required|string',
        'WINE_TYPE_ADD_WINE_TYPE_DESC_LABEL' => 'required|string',
        'WINE_TYPE_ADD_WINE_TYPE_DESC_PLACEHOLDER' => 'required|string',
        'WINE_TYPE_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_TYPE_ADD_WINE_TYPE_COLOR_LABEL' => 'required|string',
        'WINE_TYPE_EDIT_WINE_TYPE_NAME_LABEL' => 'required|string',
        'WINE_TYPE_EDIT_WINE_TYPE_NAME_PLACEHOLDER' => 'required|string',
        'WINE_TYPE_EDIT_WINE_TYPE_DESC_LABEL' => 'required|string',
        'WINE_TYPE_EDIT_WINE_TYPE_DESC_PLACEHOLDER' => 'required|string',
        'WINE_TYPE_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_TYPE_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'WINE_TYPE_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINE_TYPE_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'WINE_TYPE_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'WINE_TYPE_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'WINE_TYPE_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'WINE_TYPE_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'WINE_SORT_CARD_NAME' => 'required|string',
        'WINE_SORT_TABLE_NAME' => 'required|string',
        'WINE_SORT_TABLE_DESC' => 'required|string',
        'WINE_SORT_TABLE_ACTIONS' => 'required|string',
        'WINE_SORT_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_SORT_ADD_WINE_SORT_NAME_LABEL' => 'required|string',
        'WINE_SORT_ADD_WINE_SORT_NAME_PLACEHOLDER' => 'required|string',
        'WINE_SORT_ADD_WINE_SORT_DESC_LABEL' => 'required|string',
        'WINE_SORT_ADD_WINE_SORT_DESC_PLACEHOLDER' => 'required|string',
        'WINE_SORT_ADD_ADD_BUTTON_TOOLTIP' => 'required|string',
        'WINE_SORT_EDIT_WINE_SORT_NAME_LABEL' => 'required|string',
        'WINE_SORT_EDIT_WINE_SORT_NAME_PLACEHOLDER' => 'required|string',
        'WINE_SORT_EDIT_WINE_SORT_DESC_LABEL' => 'required|string',
        'WINE_SORT_EDIT_WINE_SORT_DESC_PLACEHOLDER' => 'required|string',
        'WINE_SORT_EDIT_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'WINE_SORT_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'WINE_SORT_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'WINE_SORT_ALERT_MSG_DELETE_TITLE' => 'required|string',
        'WINE_SORT_ALERT_MSG_DELETE_TEXT' => 'required|string',
        'WINE_SORT_ALERT_MSG_DELETE_SUCCESS_TITLE' => 'required|string',
        'WINE_SORT_ALERT_MSG_DELETE_SUCCESS_TEXT' => 'required|string',
        'WINE_SORT_ALERT_MSG_DELETE_UNSUCCESS' => 'required|string',
        'LOGIN_CARD_TITLE' => 'required|string',
        'LOGIN_EMAIL_LABEL' => 'required|string',
        'LOGIN_EMAIL_PLACEHOLDER' => 'required|string',
        'LOGIN_PASSWORD_LABEL' => 'required|string',
        'LOGIN_PASSWORD_PLACEHOLDER' => 'required|string',
        'LOGIN_BUTTON_TITLE' => 'required|string',
        'TRANSLATE_CARD_NAME' => 'required|string',
        'TRANSLATE_LANG_NAME_LABEL' => 'required|string',
        'TRANSLATE_LANG_CODE_LABEL' => 'required|string',
        'TRANSLATE_LANG_MOBILE_TAB_TITLE' => 'required|string',
        'TRANSLATE_LANG_FRONTEND_TAB_TITLE' => 'required|string',
        'TRANSLATE_EDIT_TABLE_NAME' => 'required|string',
        'TRANSLATE_EDIT_TABLE_VALUE' => 'required|string',
        'TRANSLATE_EDIT_BUTTON_TOOLTIP' => 'required|string',
        'TRANSLATE_ADD_CARD_NAME' => 'required|string',
        'TRANSLATE_ADD_MOBILE_TAB_TITLE' => 'required|string',
        'TRANSLATE_ADD_FRONT_END_TAB_TITLE' => 'required|string',
        'TRANSLATE_ADD_TABLE_KEY_NAME' => 'required|string',
        'TRANSLATE_ADD_TABLE_EXAMPLE' => 'required|string',
        'TRANSLATE_ADD_TABLE_INPUT' => 'required|string',
        'TRANSLATE_ADD_BUTTON_LABEL' => 'required|string',
        'TRANSLATE_SAVE_BUTTON_LABEL' => 'required|string',
        'TRANSLATE_ALERT_MSG_SUCCESS_CREATED' => 'required|string',
        'TRANSLATE_ALERT_MSG_SUCCESS_EDITED' => 'required|string',
        'LOGIN_ALERT_MSG_UNSUCCESS_LOGIN' => 'required|string',
        'LOGIN_ALERT_MSG_SUCCESS_LOGIN' => 'required|string',
        'ADDONS_REQUIRED_FIELD_LABEL' => 'required|string',
        'ADDONS_FIELD_REQUIRED' => 'required|string',
        'ADDONS_WEB_FIELD_PATTERN' => 'required|string',
        'ADDONS_USERS_FIELD_PASSWORD_MISS_PATTERN' => 'required|string',
        'ADDONS_USERS_FIELD_CONFIRM_PASSWORD_NOT_EQUAL' => 'required|string',
        'ADDONS_USERS_FIELD_OLD_PASSWORD_NOT_CORRECT' => 'required|string',
        'ADDONS_USERS_FIELD_PASSWORD_LENGTH' => 'required|string',
        'ADDONS_USERS_FIELD_EMAIL_PATTERN' => 'required|string',
        'ADDONS_USERS_FIELD_EMAIL_INVALID' => 'required|string',
        'TABLES_ELEMENTS_PER_PAGE' => 'required|string',
        'TABLES_PREVIOUS_PAGE_TOOLTIP' => 'required|string',
        'TABLES_NEXT_PAGE_TOOPTIP' => 'required|string',
        'TABLES_PREVIEW_TOOLTIP' => 'required|string',
        'TABLES_DELETE_TOOLTIP' => 'required|string',
        'TABLES_EDIT_TOOLTIP' => 'required|string',
        'TABLES_RECOMMENDED_TOOLTIP' => 'required|string',
        'TABLES_HIGHLIGHTED_TOOLITP' => 'required|string',
        'TABLES_IS_RECOMMENDED_TOOLTIP' => 'required|string',
        'TABLES_IS_NOT_RECOMMENDED_TOOLTIP' => 'required|string',
        'TABLES_IS_HIGHLIGHTED_TOOLTIP' => 'required|string',
        'TABLES_IS_NOT_HIGHLIGHTED_TOOLTIP' => 'required|string',
        'TABLES_CHOOSE_LANG_LABEL' => 'required|string',
        'TABLES_SELECT' => 'required|string',
        'TABLES_CLICK_FOR_PREVIEW' => 'required|string',
        'TABLES_RATE_STATUS_APPROVED' => 'required|string',
        'TABLES_RATE_STATUS_DEAPPROVED' => 'required|string',
        'TABLES_RATE_STATUS_HOLD' => 'required|string',
        'FILES_ALERT_MSG_VIDEO_FILE_IS_NOT_VIDEO' => 'required|string',
        'FILES_ALERT_MSG_VIDEO_FILE_FORMAT' => 'required|string',
        'FILES_ALERT_MSG_IMAGE_FILE_IS_NOT_IMAGE' => 'required|string',
        'FILES_ALERT_MSG_IMAGE_FILE_FORMAT' => 'required|string',
        'FILES_ALERT_MSG_SERVER_ERRROR' => 'required|string',
        'FILES_ALERT_MSG_INVALID_IMAGE' => 'required|string',
        'FILES_ALERT_MSG_INVALID_VIDEO_OR_IMAGE' => 'required|string',
        'ALERT_BUTTONS_YES' => 'required|string',
        'ALERT_BUTTONS_NO' => 'required|string',
        'ALERT_SERVER_ERROR' => 'required|string',
        'LOADING_TITLE' => 'required|string',
        'LANG_ADD_BUTTON_TITLE' => 'required|string',
        'LANG_DROPDOWN_TITLE' => 'required|string',
        'LANG_DELETE_TOOLTIP' => 'required|string',
        'LANG_SAVE_BUTTON_TITLE' => 'required|string',
        'LANG_ALERT_SUCCESS_SAVED' => 'required|string',
        'LANG_ALERT_REQ_SAVE_PREVIOUS_LANG' => 'required|string',
        'BUTTONS_ADD_IMAGE' => 'required|string',
        'BUTTONS_ADD_COVER' => 'required|string',
        'BUTTONS_ADD_VIDEO' => 'required|string',
        'BUTTONS_ADD_BACKGROUND_IMAGE' => 'required|string',
        'BUTTONS_CHANGE_IMAGE' => 'required|string',
        'BUTTONS_REMOVE_IMAGE' => 'required|string',
        'BUTTONS_ADD_LANG' => 'required|string',
        'BUTTONS_DELETE_LANG_TOOLTIP' => 'required|string',
        'BUTTONS_DELETE_MARKERS' => 'required|string',
        'BUTTONS_GALLERY_ADD_IMAGES' => 'required|string',
        'BUTTONS_GALLERY_ADD_VIDEOS' => 'required|string',
        'BUTTONS_GALLERY_DELETE_VIDEO_TOOLTIP' => 'required|string',
        'BUTTONS_GALLERY_DELETE_IMAGES_TOOLTIP' => 'required|string',
        'IMAGE_LOGO_TITLE' => 'required|string',
        'IMAGE_COVER_TITLE' => 'required|string',
        'IMAGE_BACKGROUND_TITLE' => 'required|string',
        'VIDEO_TITLE' => 'required|string',
        'IMAGE_BOTTLE_TITLE' => 'required|string',
        'IMAGE_EXAMPLE' => 'required|string',
        'SWAL_DELETE_LANG_TITLE' => 'required|string',
        'SWAL_DELETE_LANG_TEXT' => 'required|string',
        'SWAL_DELETE_LANG_SUCCESS_TITLE' => 'required|string',
        'SWAL_DELETE_LANG_SUCCESS_TEXT' => 'required|string',
        'SWAL_DELETE_LANG_UNSUCCESS' => 'required|string',
        'SIDEBAR_ADVERTISING_TITLE' => 'required|string',
        'SIDEBAR_ADVERTISING_SUBMENU_1' => 'required|string',
        'SIDEBAR_ADVERTISING_SUBMENU_2' => 'required|string',
        'SIDEBAR_ADVERTISING_SUBMENU_3' => 'required|string',
        'SIDEBAR_ADVERTISING_SUBMENU_3' => 'required|string',
        'SIDEBAR_ADVERTISING_SUBMENU_4' => 'required|string',
        'ADVERTISING_ADD_EVENT'=>'required|string',
        'ADS_IMAGE'=>'required|string',
        'ADS_TITLE'=>'required|string',
        'ADS_START_DATE'=>'required|string',
        'ADS_END_DATE'=>'required|string',
        'ADS_ACTIVE'=>'required|string',
        'ADS_EDIT'=>'required|string',
        'ADS_DELETE'=>'required|string',
        'ADS_SECTION'=>'required|string',
        'ADS_REPEATING'=>'required|string',
        'ADS_ADD_IMAGE'=>'required|string',
        'ADS_WINERY_NAME'=>'required|string',
        'ADS_WINERY_SEARCH'=>'required|string',
        'ADS_WINERY_LANGUAGE'=>'required|string',
        'ADS_WINERY_NAME'=>'required|string',
        "ADS_WINERY_ADDRESS"=>'required|string',
        "ADS_WINERY_REGION"=>'required|string',
        "ADS_WINERY_OPTIONS"=>'required|string',
        "ADS_WINERY_RECOMMENDED"=>'required|string',
        "ADS_WINERY_HIGHLIGHTED"=>'required|string',
        "ADS_WINERY_NOT_RECOMMENDED"=>'required|string',
        "ADS_WINERY_NOT_HIGHLIGHTED"=>'required|string',
        "ADS_ELEMENTS_PER_PAGE"=>'required|string',
        "ADS_WINE_NAME"=>'required|string',
        "ADS_WINE_SEARCH"=>'required|string',
        "ADS_WINE_LANGUAGE"=>'required|string',
        'ADS_WINE_YEAR'=>'required|string',
        'ADS_WINE_WINERY_NAME'=>'required|string',
        'ADS_WINE_OPTIONS'=>'required|string',
        'ADS_GOOGLE'=>'required|string',
        'WINERY_ADD_MONDAY'=> 'required|string',
        'WINERY_ADD_TUESDAY'=> 'required|string',
        'WINERY_ADD_WEDNESDAY'=> 'required|string',
        'WINERY_ADD_THURSDAY'=> 'required|string',
        'WINERY_ADD_FRIDAY'=> 'required|string',
        'WINERY_ADD_SATURDAY'=> 'required|string',
        'WINERY_ADD_SUNDAY'=> 'required|string',
        'CHANGE_PASSWORD_INPUT'=>'required|string',
        'TABLES_WINERY_SEARCH_FIELD_LABEL'=> 'required|string',
        'TABLES_RESET_FIELDS_BTN_TEXT'=> 'required|string',
        'TABLES_WINE_SEARCH_FIELD_LABEL'=> 'required|string',
        'SIDEBAR_COMMENTS_SUBMENU_1'=> 'required|string',
        'SIDEBAR_COMMENTS_SUBMENU_2'=> 'required|string',
        'TABLES_USERS_SEARCH_FIELD_LABEL'=> 'required|string',
        'TABLES_ARTICLE_SEARCH_FIELD_LABEL'=> 'required|string',
        'TABLES_EVENTS_SEARCH_FIELD_LABEL'=> 'required|string',
        'RATE_WINERY_TABLE_NAME'=> 'required|string',
        'RATE_WINE_TABLE_NAME'=> 'required|string'
    ];



}
