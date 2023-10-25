<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request){
        try{
            $team = Team::with(['featured_image'])->where('status', 1);
            if(!empty($request->featured))
                $team->where('is_featured', 1);
            if(!empty($request->limit))
                $team = $team->orderBy('priority')->paginate($request->limit);
            else
                $team = $team->orderBy('priority')->get();
            
            return new TeamCollection($team);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
