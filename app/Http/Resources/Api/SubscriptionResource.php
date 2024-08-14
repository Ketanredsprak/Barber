<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";
        $name = "subscription_name_". $language;
        $detail = "subscription_detail_". $language;

        return [
            'id' => $this->id,
            'subscription_name' => $this->$name,
            'subscription_detail' => $this->$detail,
            'price' => $this->price,
            'duration_in_months' => $this->duration_in_months,
            'number_of_booking' => $this->number_of_booking,
        ];

    }
}
