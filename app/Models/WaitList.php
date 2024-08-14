<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitList extends Model
{
    use HasFactory;

    protected $table="wait_lists";

    protected $fillable = [
        "booking_id",
        "any_date",
        "any_time",
        "select_date",
        "selected_date",
        "select_time",
        "selected_time",
        "select_time_range",
        "from_time",
        "to_time",
        "select_date_range",
        "from_date",
        "to_date",
    ];
}
