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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'tagline' => $this->tagline,
            'title' => $this->title,
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
            'highlights' => (!empty($this->highlights_listings))? new ListingResourceCollection($this->highlights_listings->list): [],
        ];
    }
}
