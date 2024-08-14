<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class MyFavoriteResource extends JsonResource
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
            'barber_id' => $this->barber->id,
            'first_name' => $this->barber->first_name ?? "",
            'last_name' => $this->barber->last_name ?? "",
            'gender' => $this->barber->gender  ?? "",
            'salon_name' =>  $this->barber->salon_name ?? "",
            'location' =>  $this->barber->location ?? "",
            'rating' => !empty($this->average_rating) ? number_format($this->average_rating, 1) : "0",
            'profile_image' => URL::to('/public/profile_image/' . ($this->barber->profile_image ?: 'user.jpg')),
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
