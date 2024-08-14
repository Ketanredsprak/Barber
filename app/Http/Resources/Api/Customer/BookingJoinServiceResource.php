<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Customer\BarberScheduleResource;
use App\Http\Resources\Api\Barber\BookingServiceDetailResorce;

class BookingJoinServiceResource extends JsonResource
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
            'booking_date' => $this->booking_date ?? "",
            'barber_id' => $this->barber_id ?? "",
            'booking_start_time' => $this->start_time ?? "",
            'booking_end_time' => $this->end_time ?? "",
            'total_slot_need_to_select' => count($this->booking_service_detailss),
            'service_details' => BookingServiceDetailResorce::collection($this->booking_service_detailss),
            'service_schedule' =>  !is_null($this->barber_schedule) ? new BarberScheduleResource($this->barber_schedule) : [],
        ];
    }
}
