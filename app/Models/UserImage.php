<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    protected $table="user_images";

    protected $fillable = [
        "user_id",
        "image",
        "is_delete",
    ];


}
