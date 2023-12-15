<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageList extends JsonResource
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
            'featured_image' => new Media($this->whenLoaded('featured_image')),
            'featured_medias' => new MediaCollection($this->whenLoaded('featured_medias')),
            'list' => (!empty($this->listing))? new ListingResourceCollection($this->listing->list): [],
        ];
    }
}
