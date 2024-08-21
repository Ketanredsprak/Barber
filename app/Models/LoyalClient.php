<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyalClient extends Model
{
    use HasFactory;

    protected $table="loyal_clients";

    protected $fillable = [
        "user_id",
        "barber_id",
    ];

    public function barber_detail(){
        return $this->hasOne(User::class, 'id', 'barber_id');
    }

    public function user_detail(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }




}
