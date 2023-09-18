<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderPhotoCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\SliderPhoto;

class CommonController extends Controller
{

    public function settings(){
        try{
            $common_settings = Cache::get('settings', function () {
                $data = [];
                $settings = Setting::whereNotIn('settings_type', ['Google', 'Smtp'])->get();
                foreach($settings as $setting)
                {
                    $data[$setting->code] = $setting->value_text;
                }
                return $data;
            });
        
            return response()->json(['data'=>$common_settings]);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sliders($slider="Home Slider"){
        try{
            $slider_photos = SliderPhoto::with(['media'])->whereHas('slider', function($query) use($slider){
                $query->where('slider_name', $slider);
            })->orderBy('priority')->get();
            return new SliderPhotoCollection($slider_photos);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
