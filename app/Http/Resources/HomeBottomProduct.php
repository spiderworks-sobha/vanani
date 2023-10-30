<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeBottomProduct extends JsonResource
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
            'short_description' => $this->short_description,
            'extra_image' => [
                'file' => $this->extra_image?->file_path,
                'title' => $this->extra_image?->title,
            ],
        ];
    }
}
