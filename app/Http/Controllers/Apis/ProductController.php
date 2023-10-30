<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsProductCollection;
use App\Http\Resources\FeaturedProductCollection;
use App\Http\Resources\HomeBottomProductCollection;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function about_us(){
        try{
            $products = Product::with(['category', 'icon', 'featured_image'])->where('status', 1)->where('list_in_home_about', 1)->take('3')->orderBy('priority')->get();
            return new AboutUsProductCollection($products);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(Request $request){
        try{
            $products = Product::with(['featured_image'])->where('status', 1)->where('is_featured', 1);
            if($tag = $request->tag){
                $products->whereHas('tags', function($query) use($tag){
                    $query->where('product_tags.tags_id', $tag);
                });
            }
            $products = $products->orderBy('priority')->get();
            return new FeaturedProductCollection($products);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function home_bottom(Request $request){
        try{
            $products = Product::with(['category', 'extra_image'])->where('status', 1)->where('list_in_home_bottom', 1)->take('3')->orderBy('priority')->get();
            return new HomeBottomProductCollection($products);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
