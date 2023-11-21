<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Http\Resources\Blog as BlogResource;
use App\Http\Resources\BlogListingCollection;
use App\Http\Resources\CategoryListingCollection;

class BlogController extends Controller
{
    public function index(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $blogs = Blog::with(['featured_image', 'tags'])->where('status', 1);
            if(!empty($data['categories'])){
                $blogs->whereIn('category_id', $data['categories']);
            }
            $blogs = $blogs->orderBy('published_on', 'DESC')->paginate($limit);
            return new BlogListingCollection($blogs);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function categories(Request $request){
        try{
            $data = $request->all();
            $limit = !empty($data['limit'])?(int)$data['limit']:10;
            $categories = Category::with(['blogs'=>function($blog){
                $blog->where('status', 1)->orderBy('published_on', 'DESC');
            }, 'blogs.featured_image', 'blogs.tags'])->where('category_type', 'Blog')->where('status', 1);
            $categories = $categories->orderBy('priority')->paginate($limit);
            return new CategoryListingCollection($categories);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function view(Request $request, $slug){
        try{
            $data = $request->all();
            $blog = Blog::with(['featured_image', 'banner_image', 'og_image', 'tags'])->where('slug', $slug)->where('status', 1)->first();
            if(!$blog)
                return response()->json(['error' => 'Not found'], 404);
            if($request->inc_visit)
                $this->saveViewCount($blog);
            $category_id = $blog->category_id;
            $blog->related_blogs = Blog::with(['featured_image', 'tags'])->where('category_id', $category_id)->where('id', '!=', $blog->id)->orderBy('published_on', 'DESC')->take(3)->get();
            return new BlogResource($blog);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function featured(){
        try{
            $blogs = Blog::where('status', 1)->take('3')->orderBy('priority')->get();
            return new BlogListingCollection($blogs);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function saveViewCount($blog){
        $blog->visit_count = $blog->visit_count+1;
        $blog->save();
    }

    public function category_listing(){
        $categories = Category::where('category_type', 'Blog')->whereHas('blogs')->where('status', 1)->orderBy('priority')->get();
        return new CategoryListingCollection($categories);
    }
}
