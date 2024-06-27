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
        "sub_title_en",
        "content_en",
        "title_ur",
        "sub_title_ur",
        "content_ur",
        "title_ar",
        "sub_title_ar",
        "content_ar",
        "title_tr",
        "sub_title_tr",
        "content_tr",
        "cms_image",
        "slug",
        "status",
        "is_delete",
    ];
}
