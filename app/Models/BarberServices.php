<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberServices extends Model
{
    use HasFactory;

    protected $table="barber_services";

    protected $fillable = [
        "barber_id",
        "service_id",
        "sub_service_id",
        "service_price",
        "special_service",
    ];
}
