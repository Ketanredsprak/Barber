<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUS extends Model
{
    use HasFactory;

    protected $table="contact_us";

    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "subject",
        "note",
        "contact_file",
        "is_delete",
    ];



}
