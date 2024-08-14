<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberSchedule extends Model
{
    use HasFactory;


    protected $table="barber_schedules";

    protected $fillable = [
        "barber_id",
        "monday_is_holiday",
        "monday_start_time",
        "monday_end_time",
        "tuesday_start_time",
        "tuesday_is_holiday",
        "tuesday_end_time",
        "wednesday_is_holiday",
        "wednesday_start_time",
        "wednesday_end_time",
        "thursday_is_holiday",
        "thursday_start_time",
        "thursday_end_time",
        "friday_is_holiday",
        "friday_start_time",
        "friday_end_time",
        "saturday_is_holiday",
        "saturday_start_time",
        "saturday_end_time",
        "sunday_is_holiday",
        "sunday_start_time",
        "sunday_end_time",
        "slot_duration",
    ];



}
