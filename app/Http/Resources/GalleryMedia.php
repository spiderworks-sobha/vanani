<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryMedia extends JsonResource
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
            'media_type' => ($this->media)?$this->media->media_type:'Youtube',
            'video_preview_image' => ($this->video_preview_image)?asset($this->video_preview_image):null,
            'media' => new Media($this->media),
            'youtube_preview' => $this->youtube_preview,
            'youtube_url' => $this->youtube_url,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
