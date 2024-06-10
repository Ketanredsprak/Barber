<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;

    protected $table="cms";

    protected $fillable = [
        "title_en",
        "content_en",
        "title_ur",
        "content_ur",
        "title_ar",
        "content_ar",
        "title_tr",
        "content_tr",
        "slug",
        "status",
        "is_delete",
    ];
}
