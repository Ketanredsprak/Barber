<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'notification_type' => $this->notification_type,
            'notification_message' =>  __('message.'.$this->notification_message),
            'notification_data' =>  $this->notification_data,
            'is_read' => $this->is_read,
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
        ];

    }
}
