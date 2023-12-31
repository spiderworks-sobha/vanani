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
            'no_of_days' => $this->no_of_days,
            'total_activity_count' => $this->total_activity_count,
            'short_description' => $this->short_description,
            'featured_image' => new Media($this->whenLoaded('featured_image')),
            'featured_medias' => new PackageGalleryCollection($this->whenLoaded('featured_medias')),
            'list' => (!empty($this->listing))? new ListingResourceCollection($this->listing->list): [],
        ];
    }
}
