<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    use HasFactory;

    protected $table="country_code";

    protected $fillable = [
        "country_code",
        "short_name",
        "phonecode",
    ];
}
