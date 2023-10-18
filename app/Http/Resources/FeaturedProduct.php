<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedProduct extends JsonResource
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
            'sub_title' => $this->sub_title,
            'featured_image' => [
                'file' => $this->featured_image?->file_path,
                'title' => $this->featured_image?->title,
            ],
        ];
    }
}
