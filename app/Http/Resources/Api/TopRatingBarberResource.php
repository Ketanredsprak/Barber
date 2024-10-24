<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class TopRatingBarberResource extends JsonResource
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
            'rating' => !empty($this->barber_ratings_avg_rating) ? number_format($this->barber_ratings_avg_rating, 1) : "0",
            'profile_image' => URL::to('/public/profile_image/' . ($this->profile_image ?: 'user.jpg')),
            'full_booked' => $this->full_booked ?? 0,
            'distance_km' => !empty($this->distance) ? number_format($this->distance, 1) : "0",
            'has_upcoming_waitlist' => $this->has_upcoming_waitlist  ?? 0,
            'has_upcoming_booking' => $this->has_upcoming_booking  ?? 0,
            'is_holiday' => $this->is_holiday ?? 0,
        ];
    }
}
