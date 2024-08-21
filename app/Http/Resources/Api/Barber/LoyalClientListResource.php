<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class LoyalClientListResource extends JsonResource
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
            'user_first_name' => $this->user_detail->first_name,
            'user_last_name' => $this->user_detail->last_name,
            'gender' => $this->user_detail->gender,
            'location' => $this->user_detail->location,
            'profile_image' => URL::to('/public/profile_image/' . ($this->user_detail->profile_image ?: 'user.jpg')),
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
