<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";

        return [
             'id' => $this->id ?? "",
             'monday_is_holiday' => $this->monday_is_holiday ?? "",
             'monday_start_time' => $this->monday_start_time ?? "",
             'monday_end_time' => $this->monday_end_time ?? "",
             'tuesday_start_time' => $this->tuesday_start_time ?? "",
             'tuesday_is_holiday' => $this->tuesday_is_holiday ?? "",
             'tuesday_end_time' => $this->tuesday_end_time ?? "",
             'wednesday_is_holiday' => $this->wednesday_is_holiday ?? "",
             'wednesday_start_time' => $this->wednesday_start_time ?? "",
             'wednesday_end_time' => $this->wednesday_end_time ?? "",
             'thursday_is_holiday' => $this->thursday_is_holiday ?? "",
             'thursday_start_time' => $this->thursday_start_time ?? "",
             'thursday_end_time' => $this->thursday_end_time ?? "",
             'friday_is_holiday' => $this->friday_is_holiday ?? "",
             'friday_start_time' => $this->friday_start_time ?? "",
             'friday_end_time' => $this->friday_end_time ?? "",
             'saturday_is_holiday' => $this->saturday_is_holiday ?? "",
             'saturday_start_time' => $this->saturday_start_time ?? "",
             'saturday_end_time' => $this->saturday_end_time ?? "",
             'sunday_is_holiday' => $this->sunday_is_holiday ?? "",
             'sunday_start_time' => $this->sunday_start_time ?? "",
             'sunday_end_time' => $this->sunday_end_time ?? "",
             'slot_duration' => $this->slot_duration ?? "",
        ];

    }
}
