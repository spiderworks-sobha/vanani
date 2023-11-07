<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeWhatWeOffer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'type' => $this->type,
            'short_description' => $this->short_description,
            'icon_image' => new Media($this->icon_image),
            'featured_image' => new Media($this->featured_image)
        ];
    }
}
