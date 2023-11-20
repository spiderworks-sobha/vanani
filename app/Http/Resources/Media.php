<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Media extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_name' => $this->file_name,
            'file_path' => asset($this->file_path),
            'file_type' => $this->file_type,
            'file_size' => $this->file_size,
            'media_type' => $this->media_type,
            'alt_text' => $this->alt_text
        ];
    }
}
