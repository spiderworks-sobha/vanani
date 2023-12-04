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
        $reviewed_on_type = explode('\\', $this->reviewable_type);
        $reviewed_on = [];
        if($this->reviewable){
            $reviewed_on['name'] = $this->reviewable->name;
            $reviewed_on['slug'] = $this->reviewable->slug;
        }
        return [
            'name' => $this->name,
            'photo' => ($this->photo)?asset($this->photo):null,
            'title' => $this->title,
            'review_type' => $this->review_type,
            'review' => ($this->review_type == "Video")?asset($this->review):$this->review,
            'reviewed_on_type' => end($reviewed_on_type),
            'reviewed_on' => $reviewed_on,
        ];
    }
}
