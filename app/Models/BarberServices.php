<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberServices extends Model
{
    use HasFactory;

    protected $table="barber_services";

    protected $fillable = [
        "barber_id",
        "service_id",
        "sub_service_id",
        "service_price",
        "special_service",
    ];

    public function service_detail(){
        return $this->hasOne(Services::class, 'id', 'service_id');
    }


    public function sub_service_detail(){
        return $this->hasOne(Services::class, 'id', 'sub_service_id');
    }






}
