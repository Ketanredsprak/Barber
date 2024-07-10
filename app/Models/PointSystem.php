<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointSystem extends Model
{
    use HasFactory;

    protected $table = 'point_systems';

    protected $fillable = [
        'per_booking_points',
        'per_active_referral_points',
        'how_many_point_equal_sr',
    ];
}
