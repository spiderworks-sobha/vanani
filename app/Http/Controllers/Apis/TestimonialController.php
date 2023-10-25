<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Http\Resources\FeaturedTestimonialCollection;

class TestimonialController extends Controller
{
    public function index(Request $request){
        try{
            $testimonials = Testimonial::with(['featured_image', 'video', 'related_product'])->where('status', 1);
            if(!empty($request->featured))
                $testimonials->where('is_featured', 1);
            if(!empty($request->limit))
                $testimonials = $testimonials->orderBy('priority')->paginate($request->limit);
            else
                $testimonials = $testimonials->orderBy('priority')->get();
            return new FeaturedTestimonialCollection($testimonials);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
