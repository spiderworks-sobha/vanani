<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Http\Resources\FeaturedTestimonialCollection;

class TestimonialController extends Controller
{
    public function featured(Request $request){
        try{
            $testimonials = Testimonial::with(['featured_image', 'video', 'related_product'])->where('status', 1)->where('is_featured', 1)->orderBy('priority')->get();
            return new FeaturedTestimonialCollection($testimonials);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
