<?php

namespace App\Http\Resources\Api\Customer;

use App\Http\Resources\Api\Customer\BarberScheduleResource;
use App\Http\Resources\Api\Customer\BarberServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class BarberDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id ?? "",
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'profile_image' => URL::to('/public/profile_image/' . ($this->profile_image ?: 'user.jpg')),
            'location' => $this->location,
            'country_name' => $this->country_name,
            'state_name' => $this->state_name,
            'city_name' => $this->city_name,
            'about_you' => $this->about_you,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'salon_name' =>  $this->salon_name ?? "",
            'rating' => !empty($this->average_rating) ? number_format($this->average_rating, 1) : "0",
            'is_favorite' => $this->is_favorite ?? 0,
            'distance' =>  !empty($this->distance) ? number_format($this->distance, 1) : "0",
            'salon_status' => $this->salon_status ?? "closed",
            'barber_service' => !is_null($this->barber_service) ? BarberServiceResource::collection($this->barber_service) : [],
            'barber_schedule' => !is_null($this->barber_schedule) ? new BarberScheduleResource($this->barber_schedule) : "",
            'barber_web_url' => $this->url,
            'created_at' => date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
            'barber_images' => BarberImagesResource::collection($this->barber_images),

        ];
    }
}
