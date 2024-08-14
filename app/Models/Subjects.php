<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'id',
        'name_en',
        'name_ar',
        'name_ur',
        'name_tr',
        'status',

    ];


}
