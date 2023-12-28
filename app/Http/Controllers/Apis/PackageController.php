<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomPackageRequest;
use App\Http\Resources\CustomPackage as ResourcesCustomPackage;
use App\Http\Resources\Package as ResourcesPackage;
use App\Http\Resources\PackageListCollection;
use App\Models\Package;
use App\Http\Resources\ReviewCollection;
use App\Models\CustomPackage;
use App\Models\Review;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $packages = Package::with(['featured_medias', 'listing', 'listing.list'])->where('status', 1);
            if($tags = $request->tags){
                $packages->whereHas('tags', function($query) use($tags){
                    $query->whereIn('package_tag.tag_id', $tags);
                });
            }
            if(!empty($data['show_on_accommodation'])){
                $packages->where('show_on_accommodation_listing', 1);
            }
            if(!empty($data['accommodation_id'])){
                $accommodation_id = $data['accommodation_id'];
                $packages->whereHas('accommodations', function($query) use($accommodation_id){
                    $query->where('accommodations.id', $accommodation_id);
                });
            }
            $packages = $packages->orderBy('priority', 'DESC')->paginate($limit);
            return new PackageListCollection($packages);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request, string $slug){
        try{
            $package = Package::with(['featured_image', 'accommodations', 'banner_image', 'schedules', 'featured_video', 'reviews', 'og_image', 'attractions', 'activities', 'tags', 'medias', 'faq'])->where('slug', $slug)->where('status', 1)->first();
            if($package){
                $other_packages = [];
                $tags = $package->tags()->pluck('tags.id')->toArray();
                if($tags){
                    $other_packages = Package::with(['featured_image'])->where('status', 1)->whereHas('tags', function($query) use($tags){
                        $query->whereIn('package_tag.tag_id', $tags);
                    })->where('id', '!=', $package->id)->orderBy('priority', 'DESC')->take(3)->get();
                }
                $package->other_packages = $other_packages;
                return new ResourcesPackage($package);
            }
            else
                return response()->json(['error' => "Package not Found!"], 404);
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


    public function custom_package_save(CustomPackageRequest $request){
        $request->validated();
        $custom_package = new CustomPackage();
        $custom_package->fill($request->all());
        if($custom_package->save()){
            if($request->activities){
                $custom_package->activities()->sync($request->activities);
            }
        }
        return response()->json(['success'=>1, 'data'=> new ResourcesCustomPackage($custom_package), 'message' => "Custom package successfully created"]);
    }
}
