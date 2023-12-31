<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedBlog extends JsonResource
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
            'category' => [
                'name' => $this->category?->name,
                'slug' => $this->category?->slug
            ],
            'featured_title' => $this->featured_title,
            'image' => [
                'file' => $this->featured_section_image?->file_path,
                'title' => $this->featured_section_image?->title
            ],
            'title' => $this->title,
            'short_description' => $this->short_description,
        ];
    }
}
