<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewCollection;

class TestimonialController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $latest_review_limit = !empty($data['latest_review_limit'])?(int)$data['latest_review_limit']:10;

        $featured_reviews = $this->featured_reviews();
        $featured_reviews_ids = $featured_reviews->pluck('id')->toArray();

        $latest_reviews = $this->latest_reviews($latest_review_limit);
        $latest_reviews_ids = $latest_reviews->pluck('id')->toArray();

        $text_reviews = Review::with(['reviewable'])->where('status', 1)->where('review_type', 'Text');
        if($featured_reviews_ids)
            $text_reviews->whereIn('id', $featured_reviews_ids);
        if($latest_reviews_ids)
            $text_reviews->whereIn('id', $latest_reviews_ids);
        $text_reviews = $text_reviews->orderBy('created_at')->paginate($limit);

        $video_reviews = Review::with(['reviewable'])->where('status', 1)->where('review_type', 'Video');
        if($featured_reviews_ids)
            $video_reviews->whereIn('id', $featured_reviews_ids);
        if($latest_reviews_ids)
            $video_reviews->whereIn('id', $latest_reviews_ids);
        $video_reviews = $video_reviews->orderBy('created_at')->paginate($limit);

        $data = [];
        $data['featured_reviews'] = new ReviewCollection($featured_reviews);
        $data['latest_reviews'] = new ReviewCollection($latest_reviews);
        $data['text_reviews'] = new ReviewCollection($text_reviews);
        $data['video_reviews'] = new ReviewCollection($video_reviews);
        return response()->json(['data'=>$data]);
    }

    public function featured(){
        $featured_reviews = $this->featured_reviews(10);
        return new ReviewCollection($featured_reviews);
    }

    protected function featured_reviews($limit=2){
        return $featured_reviews = Review::with(['reviewable'])->where('status', 1)->orderBy('priority')->take($limit)->get();
    }

    protected function latest_reviews($limit=10){
        return $latest_reviews = Review::with(['reviewable'])->where('status', 1)->orderBy('created_at')->take($limit)->get();
    }

    public function texts(Request $request){
        $data = $request->all();
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $latest_review_limit = !empty($data['latest_review_limit'])?(int)$data['latest_review_limit']:10;

        $featured_reviews = $this->featured_reviews();
        $featured_reviews_ids = $featured_reviews->pluck('id')->toArray();

        $latest_reviews = $this->latest_reviews($latest_review_limit);
        $latest_reviews_ids = $latest_reviews->pluck('id')->toArray();

        $text_reviews = Review::with(['reviewable'])->where('status', 1)->where('review_type', 'Text');
        if($featured_reviews_ids)
            $text_reviews->whereNotIn('id', $featured_reviews_ids);
        if($latest_reviews_ids)
            $text_reviews->whereNotIn('id', $latest_reviews_ids);
        $text_reviews = $text_reviews->orderBy('created_at')->paginate($limit);
        return new ReviewCollection($text_reviews);
    }

    public function videos(Request $request){
        $data = $request->all();
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $latest_review_limit = !empty($data['latest_review_limit'])?(int)$data['latest_review_limit']:10;

        $featured_reviews = $this->featured_reviews();
        $featured_reviews_ids = $featured_reviews->pluck('id')->toArray();

        $latest_reviews = $this->latest_reviews($latest_review_limit);
        $latest_reviews_ids = $latest_reviews->pluck('id')->toArray();

        $video_reviews = Review::with(['reviewable'])->where('status', 1)->where('review_type', 'Video');
        if($featured_reviews_ids)
            $video_reviews->whereNotIn('id', $featured_reviews_ids);
        if($latest_reviews_ids)
            $video_reviews->whereNotIn('id', $latest_reviews_ids);
        $video_reviews = $video_reviews->orderBy('created_at')->paginate($limit);
        return new ReviewCollection($video_reviews);
    }
}
