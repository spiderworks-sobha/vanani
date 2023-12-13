<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderPhotoCollection;
use Illuminate\Http\Request;
use App\Models\SliderPhoto;
use App\Models\FrontendPage;
use App\Http\Resources\FrontendPage as FrontendPageResource;
use App\Http\Resources\HomeWhatWeOfferCollection;
use App\Http\Resources\Widget as WidgetResource;
use App\Models\Accommodation;
use App\Models\Package;
use App\Models\Rental;
use App\Models\Widget;
use DB;
use stdClass;

class CommonController extends Controller
{

    public function settings(){
        try{
            
            $common_settings = $this->getSettings();
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
                $is_featured = ($request->is_featured)?1:0;
                if($type == 'accommodation'){
                    $tags->join('accommodation_tag', 'tags.id', '=', 'accommodation_tag.tag_id')->join('accommodations', function($join) use($is_featured){
                        $join->on('accommodations.id', '=', 'accommodation_tag.accommodation_id')->where('accommodations.status', 1);
                        if($is_featured)
                            $join->where('is_featured');
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

    public function home_what_we_offer(){
        $data = [];
        $rental = Rental::with('icon_image', 'featured_image')->where('status', 1)->where('show_on_offer', 1)->first();
        $rental->type = "Rental";
        $data[] = $rental;
        $accommodation = Accommodation::with('icon_image', 'featured_image')->where('status', 1)->where('show_on_offer', 1)->first();
        $accommodation->type = "Accommodation";
        $data[] = $accommodation;
        $package = Package::with('icon_image', 'featured_image')->where('status', 1)->where('show_on_offer', 1)->first();
        $package->type = "Package";
        $data[] = $package;
        return new HomeWhatWeOfferCollection($data);
    }
    
}
