<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberRating extends Model
{
    use HasFactory;

    protected $table="barber_ratings";

    protected $fillable = [
        "booking_id",
        "barber_id",
        "user_id",
        "rating",
    ];

}
