<?php

namespace App\Http\Resources\Api\Barber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class DisableDateByBarberResource extends JsonResource
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
            'disable_type' => $this->disable_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
