<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogandNews extends Model
{
    use HasFactory;

    protected $table="blog_and_news";

    protected $fillable = [
        "title_en",
        "title_ar",
        "title_ur",
        "title_tr",
        "content_en",
        "content_ar",
        "content_ur",
        "content_tr",
        "blog_image",
        "status",
        "is_delete",
    ];
}
