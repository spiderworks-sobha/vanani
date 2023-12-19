<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomPackage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'accommodation' => new AccommodationList($this->accommodation),
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'country' => $this->country,
            'location' => $this->location,
            'duration' => $this->duration,
            'no_of_individuals' => $this->no_of_individuals,
            'activities' => new ActivityCollection($this->activities),
        ];
    }
}
