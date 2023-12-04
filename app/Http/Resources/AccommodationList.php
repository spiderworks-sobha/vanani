<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'tagline' => $this->tagline,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'featured_image' => new MediaCollection($this->whenLoaded('featured_image')),
            'featured_medias' => new MediaCollection($this->whenLoaded('featured_medias')),
            'featured_features' => new AmenityCollection($this->whenLoaded('featured_features')),
        ];
    }
}
