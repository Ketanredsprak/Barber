<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->user_type ==  "customer")
        {
            return [
                'id' => $this->id,
                'barber_id' => $this->barber_detail->id,
                'first_name' => $this->barber_detail->first_name,
                'last_name' => $this->barber_detail->last_name,
                'profile_image' => $this->barber_detail->profile_image ?? "",
                'chat_unique_key' => $this->chat_unique_key ?? "",
                'last_message' => $this->last_message->message ?? "",
                'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            ];
        }
        else
        {
            return [
                'id' => $this->id,
                'user_id' => $this->customer_detail->id,
                'first_name' => $this->customer_detail->first_name,
                'last_name' => $this->customer_detail->last_name,
                'profile_image' => $this->customer_detail->profile_image ?? "",
                'chat_unique_key' => $this->chat_unique_key ?? "",
                'last_message' => $this->last_message->message ?? "",
                'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            ];
        }


    }
}
