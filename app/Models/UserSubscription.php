<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table = "user_subscriptions";

    protected $fillable = [
        "user_id",
        "transaction_id",
        "subscription_id",
        "subscription_duration",
        "status",
        "availble_booking",
        "start_date_time",
        "end_date_time",
    ];

    public function subscription_detail()
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id')
            ->select('id', 'subscription_name_ar', 'subscription_name_en', 'subscription_name_tr', 'subscription_name_ur');
    }

    // Define the relationship to Subscription model
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    // Define the relationship to user model
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
