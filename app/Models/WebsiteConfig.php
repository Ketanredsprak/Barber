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
        "tiktok_link",
        "twitter_link",
        "linkedin_link",
        "youtube_link",
        'customer_app_login_image',
        'barber_app_login_image',
        'customer_app_title_en',
        'customer_app_title_ar',
        'customer_app_title_ur',
        'customer_app_title_tr',
        'customer_app_content_en',
        'customer_app_content_ar',
        'customer_app_content_ur',
        'customer_app_content_tr',
        'barber_app_title_en',
        'barber_app_title_ar',
        'barber_app_title_ur',
        'barber_app_title_tr',
        'barber_app_content_en',
        'barber_app_content_ar',
        'barber_app_content_ur',
        'barber_app_content_tr',
        'play_store_link',
        'app_store_link',
        'km_range',
    ];

}
