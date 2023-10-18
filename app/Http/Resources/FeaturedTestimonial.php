<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedTestimonial extends JsonResource
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
            'title' => $this->title,
            'short_comment' => $this->short_comment,
            'comment_type' => $this->comment_type,
            'comment' => $this->comment,
            'youtube_link' => $this->youtube_link,
            'user_image' => [
                'file' => $this->featured_image?->file_path,
                'title' => $this->featured_image?->title,
            ],
            'video' => [
                'file' => $this->video?->file_path,
                'title' => $this->video?->title,
            ],
            'related_product' => [
                'slug' => $this->related_product?->slug,
                'name' => $this->related_product?->name,
            ],
        ];
    }
}
