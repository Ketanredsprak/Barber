<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberBookingDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language_code = $request->header('language');
        $service_name = "service_name_" . $language_code;

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'barber_id' => $this->barber_id,
            'customer_first_name' => $this->customer_detail->first_name ?? "",
            'customer_last_name' => $this->customer_detail->last_name ?? "",
            'customer_gender' => $this->customer_detail->gender ?? "",
            'customer_profile_image' => URL::to('/public') . '/profile_image/' . ($this->customer_detail->profile_image ?? 'user.png'),
            'booked_services' => $this->booking_service_detailss
            ->pluck($service_name)
            ->implode(', '),
            'booking_date_time' => date('M-d-Y', strtotime($this->booking_date)) .' - '. date('h:i A', strtotime($this->start_time)) ?? "",
           ];
    }
}
