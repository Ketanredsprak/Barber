<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table="bookings";

    protected $fillable = [
       "user_id",
       "barber_id",
       "booking_date",
       "total_price",
       "start_time",
       "end_time",
       "status",
       "booking_type",
       "is_reschedule",
    ];

    public function barber_detail(){
        return $this->hasOne(User::class, 'id', 'barber_id');
    }

    public function customer_detail(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function booking_service_detailss(){
        return $this->hasMany(BookingServiceDetail::class, 'booking_id', 'id');
    }



    public function barber_proposal(){
        return $this->hasOne(BarberProposal::class, 'booking_id', 'id');
    }
    public function barber_reting(){
        return $this->hasOne(BarberRating::class, 'booking_id', 'id');
    }


    public function customer_prefrences(){
        return $this->hasMany(WaitList::class, 'booking_id', 'id');
    }

    public function barberRatings()
    {
        return $this->hasManyThrough(BarberRating::class, Barber::class, 'id', 'barber_id', 'barber_id', 'id');
    }



}
