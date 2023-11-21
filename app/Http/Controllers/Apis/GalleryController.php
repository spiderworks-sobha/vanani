<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\Gallery as ResourcesGallery;
use App\Http\Resources\GalleryCollection;
use App\Http\Resources\GalleryMediaCollection;
use App\Models\Gallery;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        $gallery = Gallery::with(['gallery'=>function($gallery){
            $gallery->take(8);
        }])->where('status', 1)->orderBy('priority')->get();

        return new GalleryCollection($gallery);
    }

    public function view(Request $request, $slug){
        
        $gallery = Gallery::without(['gallery'])->where('status', 1)->where('slug', $slug)->first();

        if($gallery)
            return new ResourcesGallery($gallery);
        else
            return response()->json(['error' => "Rental not Found!"], 404);
    }

    public function medias(Request $request, $slug){
        $limit = $request->limit?$request->limit:8;
        $medias = GalleryMedia::whereHas('gallery', function($gallery) use($slug){
            $gallery->where('slug', $slug)->where('status', 1);
        })->paginate($limit);

        return new GalleryMediaCollection($medias);
    }
}
