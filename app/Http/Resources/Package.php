<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Package extends JsonResource
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
            'title' => $this->title,
            'tagline' => $this->tagline,
            'short_description' => $this->short_description,
            'summary' => $this->precessSummary($this->summary),
            'no_of_days' => $this->no_of_days,
            'total_activity_count' => $this->total_activity_count,
            'whatsapp_number' => $this->whatsapp_number,
            'featured_image' => new Media($this->featured_image),
            'banner_image' => new Media($this->banner_image),
            'featured_video' => new Media($this->featured_video),
            'browser_title' => $this->browser_title,
            'og_title' => $this->og_title,
            'meta_description' => $this->meta_description,
            'og_description' => $this->og_description,
            'og_image' => new Media($this->og_image),
            'meta_keywords' => $this->meta_keywords,
            'bottom_description' => $this->bottom_description,
            'extra_js' => $this->extra_js,
            'accommodations' => new AccommodationListCollection($this->accommodations),
            'attractions' => new AttractionCollection($this->attractions),
            'medias' => new PackageGalleryCollection($this->medias),
            'schedules' => new PackageScheduleCollection($this->schedules),
            'tags' => new TagCollection($this->tags),
            'reviews' => new ReviewCollection($this->reviews),
            'faq' => new FaqCollection($this->faq),
            'other_packages' => new PackageListCollection($this->other_packages)
        ];
    }

    protected function precessSummary($summary){
        $summary = explode(',', $summary);
        $summary = array_map(function($item){
            return trim($item);
        }, $summary);
        return $summary;
    }
}
