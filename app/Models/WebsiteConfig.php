<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteConfig extends Model
{
    use HasFactory;

    protected $table = "website_configs";

    protected $fillable = [
        "header_logo ",
        "footer_logo ",
        "location_en",
        "location_ar",
        "location_ur",
        "location_tr",
        "phone",
        "whatsapp",
        "email",
        "facebook_link",
        "twitter_link",
        "linkedin_link",
        "youtube_link",
    ];

}
