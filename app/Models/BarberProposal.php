<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberProposal extends Model
{
    use HasFactory;

    protected $table="barber_proposals";

    protected $fillable = [
        "booking_id",
        "slots",
        "booking_date",
        "status",
        "user_id",
        "barber_id",
    ];

    protected $casts = [
        'slots' => 'array',
    ];

    public function booking_info(){
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }


}
