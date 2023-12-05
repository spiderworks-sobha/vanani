<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->pivot->title,
            'description' => $this->pivot->description,
            'video_preview_image' => ($this->pivot->video_preview_image)?asset($this->pivot->video_preview_image):null,
            'media' => new Media($this)
        ];
    }
}
