<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'referral_code',
        'email',
        'profile_image',
        'country_code',
        'otp',
        'phone',
        'nationality',
        'iqama_no',
        'health_license',
        'store_registration',
        'health_license_expiration_date',
        'store_registration_expiration_date',
        'iqama_no_expiration_date',
        'salon_name',
        'location',
        'country_name',
        'state_name',
        'city_name',
        'about_you',
        'latitude',
        'longitude',
        'user_type',
        'register_type',
        'register_method',
        'is_approved',
        'password',
        'token',
        'fcm_token',
        'notification_status',
        'remember_token',
        'created_at',
        'updated_ats',
        'is_delete',
     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function barber_service(){
        return $this->hasMany(BarberServices::class, 'barber_id', 'id');
    }


    public function barber_schedule(){
        return $this->hasOne(BarberSchedule::class, 'barber_id', 'id');
    }

    public function barber_rating(){
        return $this->hasMany(BarberRating::class, 'barber_id', 'id');
    }

    public function averageRating()
    {
        $average = $this->barber_rating->avg('rating') ?? 0;
        return round($average, 2); // Rounds the average to one decimal place
    }

    public function user_subscriptions(){
        return $this->hasMany(UserSubscription::class, 'user_id', 'id');
    }


    public function barberRatings()
    {
        return $this->hasMany(BarberRating::class, 'barber_id');
    }


}
