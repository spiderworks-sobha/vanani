<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rental as ResourcesRental;
use App\Http\Resources\RentalListCollection;
use App\Http\Resources\ReviewCollection;
use App\Models\Rental;
use App\Models\Review;
use Illuminate\Http\Request;

class RentalController extends Controller
{

    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $rentals = Rental::with(['featured_image'])->where('status', 1);
            if($tags = $request->tags){
                $rentals->whereHas('tags', function($query) use($tags){
                    $query->whereIn('rental_tag.tag_id', $tags);
                });
            }
            $rentals = $rentals->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
            return new RentalListCollection($rentals);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(Request $request){
        try{
            $rentals = Rental::with(['featured_image', 'extra_image'])->where('status', 1);
            if($tags = $request->tags){
                $rentals->whereHas('tags', function($query) use($tags){
                    $query->whereIn('rental_tag.tag_id', $tags);
                });
            }
            $rentals->where('is_featured', 1)->orderBy('priority', 'DESC');
            if($limit = $request->limit)
                $rentals->take($limit);
            
            $rentals = $rentals->get();
            return new RentalListCollection($rentals);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request, string $slug){
        try{
            $rental = Rental::with(['featured_image', 'banner_image', 'og_image', 'featured_video', 'amenities', 'activities', 'tags', 'medias', 'faq', 'reviews'])->where('slug', $slug)->where('status', 1)->first();
            if($rental)
                return new ResourcesRental($rental);
            else
                return response()->json(['error' => "Rental not Found!"], 404);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reviews(){
        try{
            $reviews = Review::where('reviewable_type', 'App\\Models\\Rental')->where('status', 1)->where('show_on_main_page', 1)->orderBy('priority')->take(3)->get();
            return new ReviewCollection($reviews);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
