<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberAccount extends JsonResource
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
            'profile_image' => URL::to('/public/profile_image/' . ($this->profile_image ?: 'user.jpg')),
            'user_type' => $this->user_type,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'nationality' => $this->nationality ?? "",
            'iqama_no' => $this->iqama_no ?? "",
            'iqama_no_expiration_date' => $this->iqama_no_expiration_date ?? "",
            'health_license' => $this->health_license ? URL::to('/public/health_license/' . $this->health_license) : null,
            'store_registration' => $this->store_registration ? URL::to('/public/store_registration/' . $this->store_registration) : null,
            'health_license_expiration_date' =>  $this->health_license_expiration_date ?? "",
            'store_registration_expiration_date' =>  $this->store_registration_expiration_date ?? "",
            'salon_name' =>  $this->salon_name ?? "",
            'location' =>  $this->location ?? "",
            'country_name' =>  $this->country_name ?? "",
            'state_name' =>  $this->state_name ?? "",
            'city_name' =>  $this->city_name ?? "",
            'about_you' =>  $this->about_you ?? "",
            'latitude' =>  $this->latitude ?? "",
            'longitude' =>  $this->longitude ?? "",
            'register_type' =>  $this->register_type ?? "",
            'register_method' =>  $this->register_method ?? "",
            'referral_code' => $this->referral_code,
            'token' => $this->token ?? "",
            'barber_schedule' => $this->barber_schedule ?? "",
            'notification_status' => $this->notification_status ?? "",
            'service_added_or_not_added' => $this->service_added_or_not_added,
            'schedule_added_or_not_added' => $this->schedule_added_or_not_added,
            'point_system' => $this->point_system ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
            'barber_images' => BarberImagesResource::collection($this->barber_images),
        ];
    }
}
