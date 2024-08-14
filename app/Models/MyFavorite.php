<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFavorite extends Model
{
    use HasFactory;

    protected $table = 'my_favorites';

    protected $fillable = [
        'user_id',
        'barber_id',
    ];


    public function barber(){
        return $this->hasOne(User::class, 'id', 'barber_id');
    }

    public function barber_rating(){
        return $this->hasMany(BarberRating::class, 'barber_id', 'id');
    }

    public function averageRating()
    {
        $average = $this->barber_rating->avg('rating') ?? 0;
        return round($average, 2); // Rounds the average to one decimal place
    }





}
