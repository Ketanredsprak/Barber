<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberBookingDetailResource extends JsonResource
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
            'user_id' => $this->user_id,
            'barber_id' => $this->barber_id,
            'customer_first_name' => $this->customer_detail->first_name ?? "",
            'customer_last_name' => $this->customer_detail->last_name ?? "",
            'customer_gender' => $this->customer_detail->gender ?? "",
            'customer_profile_image' => URL::to('/public/profile_image/' . ($this->customer_detail->profile_image ?: 'user.jpg')),
            'customer_location' => $this->customer_detail->country_name . ' - ' . $this->customer_detail->state_name . ' - ' .  $this->customer_detail->city_name,
            'service_details' => BookingServiceDetailResorce::collection($this->booking_service_detailss),
            'customer_prefrences' => $this->customer_prefrences,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'booking_type' => $this->booking_type,
            'direct_accept' => $this->direct_accept,
            'booking_date_time' => date('M-d-Y', strtotime($this->booking_date)) .' - '. date('h:i A', strtotime($this->start_time)) ?? "",
            'waitlist' => $this->waitlist ?? "",
            'barber_proposal' => $this->barber_proposal ?? "",
        ];
    }
}
