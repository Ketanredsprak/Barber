<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAccount extends JsonResource
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
            'profile_image' => URL::to('/public') . '/profile_image/' .$this->profile_image ?? "user.jpg",
            'user_type' => $this->user_type,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'referral_code' => $this->referral_code,
            'token' => $this->token ?? "",
            'country_code' => $this->country_code ?? "",
            'location' => $this->location ?? "",
            'country_name' => $this->country_name ?? "",
            'state_name' => $this->state_name ?? "",
            'city_name' => $this->city_name ?? "",
            'latitude' => $this->latitude ?? "",
            'longitude' => $this->longitude ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
