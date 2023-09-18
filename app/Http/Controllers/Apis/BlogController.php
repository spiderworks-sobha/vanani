<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Http\Resources\Blog as BlogResource;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\FeaturedBlogCollection;

class BlogController extends Controller
{
    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $blogs = Blog::with(['featured_image', 'category'])->where('status', 1);
            if(!empty($data['categories'])){
                $blogs->whereIn('category_id', $data['categories']);
            }
            $blogs = $blogs->orderBy('published_on', 'DESC')->paginate($limit);
            return new BlogCollection($blogs);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function categories(Request $request){
        try{
            $categories = Category::where('category_type', 'Blog')->where('status', 1)->orderBy('name')->get();
            return new CategoryCollection($categories);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function view(Request $request, $slug){
        try{
            $data = $request->all();
            $blog = Blog::with(['featured_image', 'banner_image', 'og_image', 'category', 'tags'])->where('slug', $slug)->where('status', 1)->first();
            if(!$blog)
                return response()->json(['error' => 'Not found'], 404);
            return new BlogResource($blog);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(){
        try{
            $blogs = Blog::where('status', 1)->take('3')->orderBy('priority')->get();
            return new FeaturedBlogCollection($blogs);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
