<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberSlotDisable extends Model
{
    use HasFactory;

    protected $table="barber_slot_disables";

    protected $fillable = [
        "barber_id",
        "disable_type",
        "date",
        "slot",
        "all_slots",
        "start_date",
        "end_date",
    ];
}
