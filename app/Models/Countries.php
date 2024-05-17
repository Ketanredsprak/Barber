<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table="countries";

    protected $fillable = [
        "shortname",
        "name_en",
        "name_ar",
        "name_ur",
        "phonecode",
        "status",
        "is_delete",
    ];

}
