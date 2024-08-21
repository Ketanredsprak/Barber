<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberListResource extends JsonResource
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
            'first_name' => $this->first_name ?? "",
            'last_name' => $this->last_name ?? "",
            'gender' => $this->gender,
            'salon_name' =>  $this->salon_name ?? "",
            'location' =>  $this->location ?? "",
            'country_name' =>  $this->country_name ?? "",
            'state_name' =>  $this->state_name ?? "",
            'city_name' =>  $this->city_name ?? "",
            'about_you' =>  $this->about_you ?? "",
            'latitude' =>  $this->latitude ?? "",
            'longitude' =>  $this->longitude ?? "",
            'rating' => !empty($this->average_rating) ? number_format($this->average_rating, 1) : "0",
            'distance_km' => !empty($this->distance) ? number_format($this->distance, 1) : "0",
            'profile_image' => URL::to('/public/profile_image/' . ($this->profile_image ?: 'user.jpg')),
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
