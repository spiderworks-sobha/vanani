<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'photo' => ($this->photo)?asset($this->photo):null,
            'review_type' => $this->review_type,
            'review' => ($this->review_type == "Video")?asset($this->review):$this->review,
        ];
    }
}
