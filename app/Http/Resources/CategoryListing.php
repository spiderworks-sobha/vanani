<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListing extends JsonResource
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
            'tag_line' => $this->tag_line,
            'title' => $this->title,
            'blogs' => new BlogListingCollection($this->whenLoaded('blogs'))
        ];
    }
}
