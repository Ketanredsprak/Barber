<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFavorite extends Model
{
    use HasFactory;

    protected $table = 'my_favorites';

    protected $fillable = [
        'user_id',
        'barber_id',
    ];



}
