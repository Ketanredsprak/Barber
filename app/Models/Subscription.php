<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table="subscriptions";

    protected $fillable = [
        "subscription_name_en",
        "subscription_name_ar",
        "subscription_name_ur",
        "subscription_name_tr",
        "subscription_detail_en",
        "subscription_detail_ar",
        "subscription_detail_ur",
        "subscription_detail_tr",
        "number_of_booking",
        "price",
        "duration_in_months",
        "subscription_type",
        "status",
        "is_delete",

    ];
}
