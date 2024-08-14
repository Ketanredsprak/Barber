<?php
namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language_code = $request->header('language');
        $service_name = "service_name_".$language_code;

        $current_date = date('Y-m-d');
        $booking_date = date('Y-m-d', strtotime($this->booking_date));

        $appointment_status = 'upcoming';
        if ($booking_date == $current_date) {
            $appointment_status = 'today';
        }

        $baseData = [
            'id' => $this->id,
            'barber_first_name' => $this->barber_detail->first_name ?? "",
            'barber_last_name' => $this->barber_detail->last_name ?? "",
            'barber_gender' => $this->barber_detail->gender ?? "",
            'salon_name' => $this->barber_detail->salon_name ?? "",
            'barber_profile_image' => URL::to('/public') . '/profile_image/' . ($this->profile_image ?? 'user.png'),
            'barber_location' => $this->barber_detail->country_name . ' - ' . $this->barber_detail->state_name . ' - ' .  $this->barber_detail->city_name,
            'service_detail' => $this->booking_service_detailss->pluck($service_name)->implode(', '),
            'status' => $this->status,
            'is_reschedule' => $this->is_reschedule,
            'total_price' => $this->total_price,
            'booking_type' => $this->booking_type,
            'appointment_status' => $appointment_status,
            'rating' => !empty($this->average_rating) ? number_format($this->average_rating, 1) : "0",
        ];

        if ($request->status === 'appointment' || $request->status === 'history') {
            $baseData['booking_date_time'] = date('M-d-Y', strtotime($this->booking_date)) . ' - ' . date('h:i A', strtotime($this->start_time)) ?? "";
        }

        if ($request->status === 'waitlist') {
            $baseData['barber_proposal'] = $this->barber_proposal ?? ""; // Assuming you have a resource for barber proposals
        }

        return $baseData;
    }
}
