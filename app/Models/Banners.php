<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $table="banners";

    protected $fillable = [
        "title_en",
        "title_ar",
        "title_ur",
        "title_tr",
        "content_en",
        "content_ar",
        "content_ur",
        "content_tr",
        "barber_id",
        "banner_image",
        "status",
        "is_delete",
    ];
}
