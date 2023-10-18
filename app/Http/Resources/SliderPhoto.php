<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderPhoto extends JsonResource
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
            'media' => [
                'file' => ($this->media)?asset($this->media?->file_path):NULL,
                'title' => $this->media?->title,
                'file_type' => $this->media?->file_type,
                'media_type' => $this->media?->media_type
            ],
            'meta_data' => $this->meta_data
        ];
    }
}
