<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SustainableTourismListingResourceCollection;
use App\Http\Resources\SustainableTourismResource;
use App\Models\FrontendPage;
use App\Models\SustainableTourismProcess;

class SustainableTourismController extends Controller
{
    public function index(){
        $processes = SustainableTourismProcess::with(['featured_image', 'icon'])->where('status', 1)->orderBy('priority')->get();
        return new SustainableTourismListingResourceCollection($processes);
    }

    public function view($slug){
        $process = SustainableTourismProcess::with(['featured_image', 'banner_image', 'og_image', 'icon'])->where('slug', $slug)->where('status', 1)->first();
        if(!$process)
                return response()->json(['error' => 'Not found'], 404);

        $processes_settings = FrontendPage::select('content')->where('slug', 'sustainable-tourism')->first()->toArray();
        $processes_settings = $processes_settings['content'];

        $other_processes_settings = [];
        foreach($processes_settings as $key=>$value){
            if($key == "detail_page_other_process_listing_title" || $key == "detail_page_other_process_listing_short_description")
                $other_processes_settings[$key] = $value;
        }

        $process->other_processes_settings = $other_processes_settings;
        $process->other_processes = SustainableTourismProcess::with(['featured_image'])
                                    ->where('id', '!=', $process->id)
                                    ->inRandomOrder()->take(3)->get();
        return new SustainableTourismResource($process);
    }
}
