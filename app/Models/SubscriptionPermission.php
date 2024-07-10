<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPermission extends Model
{
    use HasFactory;

    protected $table="subscription_permissions";

    protected $fillable = [
        "permission_name",
        "permission_for_user",
        "permission_type",
        "permission_detail",
        "basic",
        "silver",
        "bronz",
        "gold",
        "basic_input_value",
        "silver_input_value",
        "bronz_input_value",
        "gold_input_value",
        "subscription_array",
        "is_input_box",
    ];

    protected $casts = [
        'subscription_array' => 'array',
    ];
}
