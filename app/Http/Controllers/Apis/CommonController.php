<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderPhotoCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\SliderPhoto;
use App\Models\FrontendPage;
use App\Http\Resources\FrontendPage as FrontendPageResource;
use App\Http\Resources\Widget as WidgetResource;
use App\Models\Widget;
use DB;

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

    public function tags(Request $request){
        try{
            $tags = DB::table('tags')->select('tags.id', 'tags.slug', 'tags.name');
            if($type = $request->type){
                if($type == 'products'){
                    $tags->join('product_tags', 'tags.id', '=', 'product_tags.tags_id')->join('products', function($join){
                        $join->on('products.id', '=', 'product_tags.products_id')->where('products.status', 1);
                    })->where('tags.status', 1)->get();
                }
                elseif($type == 'featured_products'){

                    $tags->join('product_tags', 'tags.id', '=', 'product_tags.tags_id')->join('products', function($join){
                        $join->on('products.id', '=', 'product_tags.products_id')->where('products.status', 1)->where('products.is_featured', 1);
                    })->where('tags.status', 1)->get();

                }
            }
            $tags = $tags->groupBy('tags.id')->get();
            return response()->json(['data'=>$tags]);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function page(string $slug){
        try{
            $page_settings = FrontendPage::with(['faq', 'og_image'])->where('slug', $slug)->where('status', 1)->first();
            if(!$page_settings)
                return response()->json(['error' => 'Page not Found!'], 404);
            return new FrontendPageResource($page_settings);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function widget(string $code){
        try{
            $widget = Widget::where('code', $code)->first();
            if(!$widget)
                return response()->json(['error' => 'Page not Found!'], 404);
            return new WidgetResource($widget);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
