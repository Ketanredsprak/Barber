<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $table="chats";

    protected $fillable = [
        "user_id1",
        "user_id2",
        "chat_unique_key",
    ];


    public function customer_detail(){
        return $this->hasOne(User::class, 'id', 'user_id1');
    }

    public function barber_detail(){
        return $this->hasOne(User::class, 'id', 'user_id2');
    }

    public function last_message(){
        return $this->hasOne(ChatList::class, 'chat_unique_key', 'chat_unique_key')->orderBy('id', 'DESC');
    }





}
