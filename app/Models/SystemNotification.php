<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    use HasFactory;


    protected $table = 'system_notifications';

    protected $fillable = [
   
        'usertype',
        'notification_type',
        'title',
        'description',
      

    ];


}
