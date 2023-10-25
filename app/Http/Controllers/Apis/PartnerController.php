<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerCollection;
use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index(Request $request){
        try{
            $partners = Partner::with(['featured_image'])->where('status', 1);
            if(!empty($request->featured))
                $partners->where('is_featured', 1);

            if(!empty($request->limit))
                $partners= $partners->orderBy('priority')->paginate($request->limit);
            else
                $partners= $partners->orderBy('priority')->get();
            return new PartnerCollection($partners);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
