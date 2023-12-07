<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\AmenityCollection;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $amenities = Amenity::with(['featured_image', 'icon'])->where('status', 1)->where('is_a_feature', 0);
        $amenities = $amenities->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
        return new AmenityCollection($amenities);
        
    }

    public function featured(Request $request){
        $amenities = Amenity::with(['featured_image', 'icon'])->where('status', 1)->where('is_a_feature', 0);
        $amenities = $amenities->where('is_featured', 1)->orderBy('priority', 'DESC')->get();
        return new AmenityCollection($amenities);
    }
}
