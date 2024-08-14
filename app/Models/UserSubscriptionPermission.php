<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscriptionPermission extends Model
{
    use HasFactory;

    protected $table="user_subscription_permissions";

    protected $fillable = [
        "user_id",
        "subscription_id",
        "permission_id",
        "permission_name",
        "permission_name",
        "is_input_box" ,
        "input_value",
        "condition",
        "status",
    ];




}
