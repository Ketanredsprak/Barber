<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
