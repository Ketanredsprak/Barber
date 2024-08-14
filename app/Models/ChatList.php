<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    use HasFactory;

    protected $table="chat_lists";

    protected $fillable = [
        "sender_id",
        "receiver_id",
        "message",
        "file",
        "message_type",
        "chat_unique_key",
        "status",
    ];

}
