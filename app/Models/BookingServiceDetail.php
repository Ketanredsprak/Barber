<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingServiceDetail extends Model
{
    use HasFactory;

    protected $table="booking_service_details";

    protected $fillable = [
      "booking_id",
      "service_id",
      "main_service_id",
      "service_name_en",
      "service_name_ar",
      "service_name_ur",
      "service_name_tr",
      "price",
      "start_time",
      "end_time",
    ];

    public function booking_detail(){
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }

    // BookingServiceDetails.php
    public function main_service()
    {
        return $this->belongsTo(Services::class, 'main_service_id');
    }


    public function sub_service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

}
