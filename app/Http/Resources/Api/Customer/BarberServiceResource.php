<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";
        $name = "service_name_". $language;

        return [
            'id' => $this->sub_service_detail->id,
            'serivce_id' => $this->service_detail->id,
            'service_name' => $this->service_detail->$name ?? "",
            'sub_service_name' => $this->sub_service_detail->$name ?? "",
            'service_price' => $this->service_price ?? 0,
            'service_image' => URL::to('/public') . '/service_image/' .$this->service_detail->service_image,
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->service_detail->created_at)),
        ];

    }
}
