<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Barber\BookingServiceDetailResorce;

class CustomerBookingDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $current_date = date('Y-m-d');
        $booking_date = date('Y-m-d', strtotime($this->booking_date));

        $appointment_status = 'upcoming'; // Default status

        if ($booking_date == $current_date) {
            $appointment_status = 'today';
        } elseif ($booking_date < $current_date) {
            $appointment_status = 'finished'; // Booking date is in the past
        } else {
            // Booking date is in the future
            $appointment_status = 'upcoming';
        }
        $response =  [
            'id' => $this->id,
            'barber_id' => $this->barber_detail->id ?? "",
            'barber_latitude' => $this->barber_detail->latitude ?? "",
            'barber_longitude' => $this->barber_detail->longitude ?? "",
            'barber_first_name' => $this->barber_detail->first_name ?? "",
            'barber_last_name' => $this->barber_detail->last_name ?? "",
            'barber_gender' => $this->barber_detail->gender ?? "",
            'distance_km' => !empty($this->distance) ? number_format($this->distance, 1) : "0",
            'salon_name' => $this->barber_detail->salon_name ?? "",
            'barber_profile_image' => URL::to('/public') . '/profile_image/' . ($this->barber_detail->profile_image ?? 'user.png'),
            'barber_location' => $this->barber_detail->country_name . ' - ' . $this->barber_detail->state_name . ' - ' .  $this->barber_detail->city_name,
            'service_details' => BookingServiceDetailResorce::collection($this->booking_service_detailss),
            'appointment_status' => $appointment_status,
            'status' => $this->status,
            'rating' => !empty($this->average_rating) ? number_format($this->average_rating, 1) : "0",
            'rating_submit' => $this->rating_submit,
            'is_reschedule' => $this->is_reschedule,
            'process_status' => $this->process_status,
            'chat_unique_key' => $this->chat_unique_key ?? "",
            'total_price' => $this->total_price,
            'booking_type' => $this->booking_type,
            'minute_start_and_end_minute_left' => $this->minute_start_and_end_minute_left ?? "",
            'booking_date_time' => date('M-d-Y', strtotime($this->booking_date)) .' - '. date('h:i A', strtotime($this->start_time)) ?? "",
            'can_reschedule' => $this->can_reschedule,
            'can_cancel' => $this->can_cancel,
        ];


        return $response;

        // Conditionally add waitlist_array if booking_type is 'waitlist'
        // if ($this->booking_type === 'waitlist') {
        //     $response['waitlist_array'] = $this->waitlist_array;
        // }

    }
}
