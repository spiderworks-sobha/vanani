<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accommodation as ResourcesAccommodation;
use App\Http\Resources\AccommodationListCollection;
use App\Models\Accommodation;
use App\Http\Resources\ReviewCollection;
use App\Models\Review;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{

    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $accommodations = Accommodation::with(['featured_image'])->where('status', 1);
            if($tags = $request->tags){
                $accommodations->whereHas('tags', function($query) use($tags){
                    $query->whereIn('accommodation_tag.tag_id', $tags);
                });
            }
            $accommodations = $accommodations->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
            return new AccommodationListCollection($accommodations);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(Request $request){
        try{
            $accommodations = Accommodation::with(['featured_image'])->where('status', 1);
            if($tags = $request->tags){
                $accommodations->whereHas('tags', function($query) use($tags){
                    $query->whereIn('accommodation_tag.tag_id', $tags);
                });
            }
            $accommodations = $accommodations->where('is_featured', 1)->orderBy('priority', 'DESC')->get();
            return new AccommodationListCollection($accommodations);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request, string $slug){
        try{
            $accommodation = Accommodation::with(['featured_image', 'banner_image', 'og_image', 'amenities', 'activities', 'tags', 'medias', 'faq'])->where('slug', $slug)->where('status', 1)->first();
            if($accommodation)
                return new ResourcesAccommodation($accommodation);
            else
                return response()->json(['error' => "Rental not Found!"], 404);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reviews(){
        try{
            $reviews = Review::where('reviewable_type', 'App\\Models\\Accommodation')->where('status', 1)->where('show_on_main_page', 1)->orderBy('priority')->take(3)->get();
            return new ReviewCollection($reviews);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
