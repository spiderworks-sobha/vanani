<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Accommodation extends JsonResource
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
            'tagline' => $this->tagline,
            'short_description' => $this->short_description,
            'content_tagline' => $this->content_tagline,
            'content' => $this->content,
            'features_tagline' => $this->features_tagline,
            'features_title' => $this->features_title,
            'features_short_description' => $this->features_short_description,
            'features_listing_title' => $this->features_listing_title,
            'all_features_tagline' => $this->all_features_tagline,
            'all_features_title' => $this->all_features_title,
            'whatsapp_number' => $this->whatsapp_number,
            'featured_image' => new Media($this->featured_image),
            'banner_image' => new Media($this->banner_image),
            'features_image' => new Media($this->features_image),
            'amenities_image' => new Media($this->amenities_image),
            'activities_image' => new Media($this->activities_image),
            'featured_video' => new Media($this->featured_video),
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
            'features' => new AmenityCollection($this->features),
            'medias' => new MediaCollection($this->medias),
            'tags' => new TagCollection($this->tags),
            'reviews' => new ReviewCollection($this->reviews),
            'faq' => new FaqCollection($this->faq)
        ];
    }
}
