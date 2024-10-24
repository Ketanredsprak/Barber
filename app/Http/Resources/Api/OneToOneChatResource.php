<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class OneToOneChatResource extends JsonResource
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
                'message_status' => $this->sender_id === Auth::id() ? 1 : 0,
                'is_read' => $this->status,
                'sender_id' => $this->sender_id,
                'receiver_id' => $this->receiver_id,
                'message_type' => $this->message_type,
                'sender_profile_image' =>  URL::to('/public/profile_image/' . ($this->sender_detail->profile_image ?: 'user.jpg')),
                'receiver_profile_image' =>  URL::to('/public/profile_image/' . ($this->receiver_detail->profile_image ?: 'user.jpg')),
                'message' => $this->when($this->message_type === 'text', $this->message),
                'file' => $this->when($this->message_type === 'file', URL::to('/public') . '/file/' .$this->file),
                'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            ];



    }
}
