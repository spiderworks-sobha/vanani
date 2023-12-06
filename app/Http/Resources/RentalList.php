<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalList extends JsonResource
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
            'title' => $this->title,
            'tagline' => $this->tagline,
            'whatsapp_number' => $this->whatsapp_number,
            'price_description' => $this->price_description,
            'short_description' => $this->short_description,
            'home_featured_listing' =>[
                'tagline' => $this->featured_home_listing_tagline,
                'title' => $this->featured_home_listing_tite,
                'sub_title' => $this->featured_home_listing_sub_heading,
                'description' => $this->featured_home_listing_description,
                'image' => new Media($this->whenLoaded('home_image')),
            ],
            'featured_image' => new Media($this->whenLoaded('featured_image')),
            'featured_medias' => new MediaCollection($this->whenLoaded('featured_medias')),
            'medias' => new MediaCollection($this->whenLoaded('medias')),
        ];
    }
}
