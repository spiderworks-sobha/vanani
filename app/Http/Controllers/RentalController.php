<?php

namespace App\Http\Controllers;

use App\Http\Resources\Rental as ResourcesRental;
use App\Http\Resources\RentalListCollection;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{

    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $rentals = Rental::with(['featured_image'])->where('status', 1);
            $rentals = $rentals->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
            return new RentalListCollection($rentals);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(Request $request){
        try{
            $rentals = Rental::with(['featured_image'])->where('status', 1);
            $rentals = $rentals->where('is_featured', 1)->orderBy('priority', 'DESC')->get();
            return new RentalListCollection($rentals);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request){
        try{
            $rental = Rental::with(['featured_image', 'banner_image', 'og_image', 'amenities', 'activities', 'tags', 'medias', 'faq'])->where('status', 1)->first();
            if($rental)
                return new ResourcesRental($rental);
            else
                return response()->json(['error' => "Rental not Found!"], 404);
        }
        catch(\Exception){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
