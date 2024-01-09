<?php

// app/Models/ChatMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'messages';
    // Other model properties and methods...

    /**
     * Get the user that owns the chat message.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
