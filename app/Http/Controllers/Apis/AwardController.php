<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\AwardCollection;
use App\Models\Award;

class AwardController extends Controller
{
    public function index(){
        $awards = Award::with(['featured_image'])->where('status', 1)->orderBy('priority')->get();
        return new AwardCollection($awards);
    }

    public function latest(){
        $awards = Award::with(['featured_image'])->where('status', 1)->orderBy('id', 'DESC')->take(4)->get();
        return new AwardCollection($awards);
    }
}
