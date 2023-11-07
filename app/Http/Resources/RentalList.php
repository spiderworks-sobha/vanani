<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'title' => $this->title,
            'price_description' => $this->price_description,
            'short_description' => $this->short_description,
            'featured_image' => new Media($this->featured_image),
            'extra' => [
                "tag" => $this->extra_tag,
                'title' => $this->extra_title,
                'short_description' => $this->extra_short_description,
                'extra_image' => new Media($this->extra_image)
            ]
        ];
    }
}