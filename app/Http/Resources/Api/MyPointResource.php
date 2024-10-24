<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class MyPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       $referral_title =  __('labels.title_referral');
       $booking_title =  __('labels.title_booking');
       $content_referral =  __('labels.content_referral');
       $content_booking =  __('labels.content_booking');

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'type' => $this->type,
            'expiry_date' => $this->expiry_date,
            'credit_type' => $this->credit_type,
            'title' =>  $this->credit_type == "booking" ? $booking_title : $referral_title,
            'content' =>  $this->credit_type == "booking" ?  $content_booking : $content_referral,
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
