<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getSettings(){
        $common_settings = Cache::get('settings', function () {
            $data = [];
            $settings = Setting::whereNotIn('settings_type', ['Google', 'Smtp'])->get();
            foreach($settings as $setting)
            {
                if($setting->code == "logo" || $setting->code == "logo_small" || $setting->code == "fav_icon")
                    $data[$setting->code] = asset($setting->value_text);
                else
                    $data[$setting->code] = $setting->value_text;
            }
            return $data;
        });
        return $common_settings;
    }
}
