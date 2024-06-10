<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cities extends Model
{
    use HasFactory;

    protected $table="cities";

    protected $fillable = [
        "name_en",
        "name_ar",
        "name_ur",
        "name_tr",
        "country_id",
        "state_id",
        "status",
        "is_delete",
    ];


    public function state_data(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}
