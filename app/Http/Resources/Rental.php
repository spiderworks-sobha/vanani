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
            'tagline' => $this->tagline,
            'title' => $this->title,
            'whatsapp_number' => $this->whatsapp_number,
            'whatsapp_text' => $this->whatsapp_text,
            'content_tagline' => $this->content_tagline,
            'content' => $this->content,
            'policy_tagline' => $this->policy_tagline,
            'policy_description' => $this->policy_description,
            'features_tagline' => $this->features_tagline,
            'features_title' => $this->features_title,
            'offer_tagline' => $this->offer_tagline,
            'offer_headering' => $this->offer_headering,
            'extra_data_title1' => $this->extra_data_title1,
            'extra_data_description1' => $this->extra_data_description1,
            'extra_data_title2' => $this->extra_data_title2,
            'extra_data_description2' => $this->extra_data_description2,
            'extra_data_title3' => $this->extra_data_title3,
            'extra_data_description3' => $this->extra_data_description3,
            'terms_and_condition_link' => $this->terms_and_condition_link,
            'price_description' => $this->price_description,
            'short_description' => $this->short_description,
            'featured_video' => new Media($this->featured_video),
            'banner_image' => new Media($this->banner_image),
            'browser_title' => $this->browser_title,
            'og_title' => $this->og_title,
            'meta_description' => $this->meta_description,
            'og_description' => $this->og_description,
            'og_image' => new Media($this->og_image),
            'meta_keywords' => $this->meta_keywords,
            'bottom_description' => $this->bottom_description,
            'extra_js' => $this->extra_js,
            'features' => new AmenityCollection($this->features),
            'medias' => new MediaCollection($this->medias),
            'reviews' => new ReviewCollection($this->reviews),
            'tags' => new TagCollection($this->tags),
            'faq' => new FaqCollection($this->faq)
        ];
    }
}
