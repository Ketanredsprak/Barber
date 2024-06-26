<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaContent extends Model
{
    use HasFactory;

    protected $table="meta_contents";

    protected $fillable = [
        "page_id",
        "meta_title_en",
        "meta_title_ar",
        "meta_title_ur",
        "meta_title_tr",
        "meta_content_en",
        "meta_content_ar",
        "meta_content_ur",
        "meta_content_tr",
    ];

}
