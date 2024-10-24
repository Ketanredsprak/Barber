<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryCodeResource extends JsonResource
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
            'image' => URL::to('/public/image/' . ($this->image ?: 'no-image.png')),
            'phonecode' => $this->phonecode,
            'short_name' => $this->short_name,
            'name' => $this->name,
        ];
    }
}
