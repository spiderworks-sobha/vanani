<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\Package as ResourcesPackage;
use App\Http\Resources\PackageListCollection;
use App\Models\Package;
use App\Http\Resources\ReviewCollection;
use App\Models\Review;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $packages = Package::with(['featured_image'])->where('status', 1);
            if($tags = $request->tags){
                $packages->whereHas('tags', function($query) use($tags){
                    $query->whereIn('package_tag.tag_id', $tags);
                });
            }
            $packages = $packages->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
            return new PackageListCollection($packages);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(Request $request){
        try{
            $packages = Package::with(['featured_image'])->where('status', 1);
            if($tags = $request->tags){
                $packages->whereHas('tags', function($query) use($tags){
                    $query->whereIn('package_tag.tag_id', $tags);
                });
            }
            $packages = $packages->where('is_featured', 1)->orderBy('priority', 'DESC')->get();
            return new PackageListCollection($packages);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request, string $slug){
        try{
            $package = Package::with(['featured_image', 'banner_image', 'og_image', 'amenities', 'activities', 'tags', 'medias', 'faq'])->where('slug', $slug)->where('status', 1)->first();
            if($package)
                return new ResourcesPackage($package);
            else
                return response()->json(['error' => "Rental not Found!"], 404);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reviews(){
        try{
            $reviews = Review::where('reviewable_type', 'App\\Models\\Package')->where('status', 1)->where('show_on_main_page', 1)->orderBy('priority')->take(3)->get();
            return new ReviewCollection($reviews);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
