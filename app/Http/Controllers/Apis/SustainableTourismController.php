<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SustainableTourismResourceCollection;
use Illuminate\Http\Request;
use App\Models\SustainableTourismProcess;

class SustainableTourismController extends Controller
{
    public function index(){
        $processes = SustainableTourismProcess::with(['featured_image', 'icon'])->where('status', 1)->orderBy('priority')->get();
        return new SustainableTourismResourceCollection($processes);
    }
}
