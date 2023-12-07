<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityCollection;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $activities = Activity::with(['featured_image', 'icon'])->where('status', 1);
        $activities = $activities->where('is_featured', '!=', 1)->orderBy('priority', 'DESC')->paginate($limit);
        return new ActivityCollection($activities);
        
    }

    public function featured(Request $request){
        $activities = Activity::with(['featured_image', 'icon'])->where('status', 1);
        $activities = $activities->where('is_featured', 1)->orderBy('priority', 'DESC')->get();
        return new ActivityCollection($activities);
    }
}
