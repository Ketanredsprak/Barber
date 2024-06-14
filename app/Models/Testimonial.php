<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = "testimonials";

    protected $fillable = [
        "name_en",
        "name_ar",
        "name_ur",
        "name_tr",
        "designation_en",
        "designation_ar",
        "designation_ur",
        "designation_tr",
        "testimonial_content_en",
        "testimonial_content_ar",
        "testimonial_content_ur",
        "testimonial_content_tr",
        "testimonial_image",
        "status",
        "is_delete",
    ];

}
