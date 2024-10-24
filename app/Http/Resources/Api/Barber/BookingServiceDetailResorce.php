<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingServiceDetailResorce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language_code = $request->header('language');
        $service_name = "service_name_".$language_code;

        return [
            'booking_id' => $this->booking_id,
            'service_id' => $this->service_id,
            'service_name' => $this->main_service->$service_name ?? "",
            'sub_service_name' => $this->$service_name ?? "",
            'service_price' => $this->price,
            'service_image' =>  URL::to('/public') . '/service_image/' . ($this->sub_service->service_image),
            'start_time' => date('h:i A', strtotime($this->start_time)) ?? "",
            'end_time' => date('h:i A', strtotime($this->end_time)) ?? "",
        ];
    }
}
