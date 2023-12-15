<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerCollection;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index(){
        $partners = Partner::with(['featured_image'])->where('status', 1)->orderBy('priority')->get();
        return new PartnerCollection($partners);
    }

    public function featured(){
        $partners = Partner::with(['featured_image'])->where('status', 1)->where('is_featured', 1)->orderBy('priority')->get();
        return new PartnerCollection($partners);
    }
}
