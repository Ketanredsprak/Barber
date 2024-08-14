<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id' => $this->id,
            'service_name' => $this->$name,
            'service_image' => URL::to('/public') . '/service_image/' .$this->service_image ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
        ];

    }
}
