<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table="states";

    protected $fillable = [
        "name_en",
        "name_ar",
        "name_ur",
        "name_tr",
        "country_id",
        "status",
        "is_delete",
    ];

    public function country_data(){
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }



}
