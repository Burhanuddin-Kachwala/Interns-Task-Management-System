<?php

// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'sender_type', 'receiver_id', 'receiver_type', 'message'
    ];

    // public function sender()
    // {
    //     dd($this->morphTo(__FUNCTION__, 'sender_type', 'sender_id'));
    //     return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    // }

    // public function receiver()
    // {
    //     return $this->morphTo(__FUNCTION__, 'receiver_type', 'receiver_id');
    // }
}
