<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsProduct extends JsonResource
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
                'slug' => $this->category?->slug,
                'name' => $this->category?->name,
            ],
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'icon' => [
                'file' => $this->icon?->file_path,
                'title' => $this->icon?->title,
            ],
            'featured_image' => [
                'file' => $this->featured_image?->file_path,
                'title' => $this->featured_image?->title,
            ],
        ];
    }
}
