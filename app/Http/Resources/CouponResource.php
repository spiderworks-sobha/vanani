<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'title' => $this->title,
            'short_description' => $this->short_description,
            'list' => (!empty($this->listing))? new ListingResourceCollection($this->listing->list): [],
            'url' => $this->url,
            'no_of_days' => $this->no_of_days,
            'icon' => new Media($this->icon)
        ];
    }
}
