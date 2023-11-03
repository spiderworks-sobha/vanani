<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Rental extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'price_description' => $this->price_description,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'featured_image' => new Media($this->featured_image),
            'banner_image' => new Media($this->banner_image),
            'browser_title' => $this->browser_title,
            'og_title' => $this->og_title,
            'meta_description' => $this->meta_description,
            'og_description' => $this->og_description,
            'og_image' => new Media($this->og_image),
            'meta_keywords' => $this->meta_keywords,
            'bottom_description' => $this->bottom_description,
            'extra_js' => $this->extra_js,
            'activities' => new ActivityCollection($this->activities),
            'amenities' => new AmenityCollection($this->amenities),
            'medias' => new MediaCollection($this->medias),
            'tags' => new TagCollection($this->tags),
            'faq' => new FaqCollection($this->faq)
        ];
    }
}
