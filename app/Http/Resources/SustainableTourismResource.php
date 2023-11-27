<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SustainableTourismResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'featured_image' => new Media($this->featured_image),
            'banner_image' => new Media($this->banner_image),
            'icon' => new Media($this->icon),
            'browser_title' => $this->browser_title,
            'og_title' => $this->og_title,
            'meta_description' => $this->meta_description,
            'og_description' => $this->og_description,
            'og_image' => new Media($this->og_image),
            'meta_keywords' => $this->meta_keywords,
            'bottom_description' => $this->bottom_description,
            'extra_js' => $this->extra_js,
            'other_processes_settings' => $this->other_processes_settings,
            'other_processes' => new SustainableTourismListingResourceCollection($this->other_processes)
        ];
    }
}
