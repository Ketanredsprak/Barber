<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class WaitListNewProposalsResource extends JsonResource
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
            'booking_id' => $this->booking_info->id ?? "",
            'barber_first_name' => $this->booking_info->barber_detail->first_name ?? "",
            'barber_last_name' => $this->booking_info->barber_detail->last_name ?? "",
            'barber_salon_name' => $this->booking_info->barber_detail->salon_name ?? "",
            'barber_location' => $this->booking_info->barber_detail->location ?? "",
            'barber_profile_image' => URL::to('/public') . '/profile_image/' . ($this->booking_info->barber_detail->profile_image ?? 'user.png'),
            'booking_date_time' => date('M-d-Y', strtotime($this->booking_date)) .' - '. date('h:i A', strtotime($this->booking_info->start_time)) ?? "",
            'barber_proposal' => "",
        ];
    }
}
