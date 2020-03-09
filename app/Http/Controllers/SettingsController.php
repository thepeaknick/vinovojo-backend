<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    class SettingsController extends BaseController
    {
        public function makeOrEdit(Request $r)
        {
            $setting=new \App\Settings;
            return $setting->createOrEdit($r);
        }

        public function getAll(Request $r)
        {
            return response()->json(\App\Settings::find(1));
        }
    }



?>
