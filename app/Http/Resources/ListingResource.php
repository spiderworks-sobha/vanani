<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meida_type' => $this->meida_type,
            'media_id' => new Media($this->media),
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
