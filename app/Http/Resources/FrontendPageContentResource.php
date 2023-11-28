<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FrontendPageContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $content = $this->resource;
        $response = [];
        foreach($content as $key=>$item){
            if (strpos($key, 'media_id') !== false)
                $response[$key] = new Media($item);
            else
                $response[$key] = $item;
        }
        return $response;
    }
}
